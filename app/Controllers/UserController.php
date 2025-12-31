<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();

        return view('users/index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return view('users/create');
    }

    public function store()
    {
        $data = [
            'email' => trim((string) $this->request->getPost('email')),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'user_type' => $this->request->getPost('user_type') ?: 'user',
            'role' => $this->request->getPost('role') ?: 'user',
            'agency_id' => $this->request->getPost('agency_id') ?: null,
            'approved' => $this->request->getPost('approved') ? 1 : 0,
        ];

        $userModel = new UserModel();
        if ($userModel->insert($data)) {
            return redirect()->to('/admin/users')->with('success', 'Pengguna berjaya dicipta');
        }

        return redirect()->back()->withInput()->with('errors', $userModel->errors());
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Pengguna tidak dijumpai');
        }

        return view('users/edit', [
            'user' => $user
        ]);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Pengguna tidak dijumpai');
        }

        $data = [
            'email' => trim((string) $this->request->getPost('email')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'user_type' => $this->request->getPost('user_type'),
            'role' => $this->request->getPost('role'),
            'agency_id' => $this->request->getPost('agency_id') ?: null,
            'approved' => $this->request->getPost('approved') ? 1 : 0,
        ];

        // Only update password if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($userModel->update($id, $data)) {
            return redirect()->to('/admin/users')->with('success', 'Pengguna berjaya dikemaskini');
        }

        return redirect()->back()->withInput()->with('errors', $userModel->errors());
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Pengguna tidak dijumpai');
        }

        // Prevent deleting admin users
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/users')->with('error', 'Tidak boleh memadam pengguna admin');
        }

        if ($userModel->delete($id)) {
            return redirect()->to('/admin/users')->with('success', 'Pengguna berjaya dipadam');
        }

        return redirect()->to('/admin/users')->with('error', 'Gagal memadam pengguna');
    }

    public function toggleStatus($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Pengguna tidak dijumpai');
        }

        // Prevent disabling admin users
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/users')->with('error', 'Tidak boleh menukar status pengguna admin');
        }

        $newStatus = $user['approved'] ? 0 : 1;
        $userModel->update($id, ['approved' => $newStatus]);

        $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->to('/admin/users')->with('success', "Pengguna berjaya {$statusText}");
    }

    public function changePassword($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Pengguna tidak dijumpai');
        }

        return view('users/change_password', [
            'user' => $user
        ]);
    }

    public function updatePassword($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Pengguna tidak dijumpai');
        }

        $newPassword = (string) $this->request->getPost('new_password');
        $confirmPassword = (string) $this->request->getPost('confirm_password');

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Kata laluan baharu tidak sepadan');
        }

        if (strlen($newPassword) < 8) {
            return redirect()->back()->with('error', 'Kata laluan baharu mesti sekurang-kurangnya 8 aksara');
        }

        $userModel->update($id, ['password' => password_hash($newPassword, PASSWORD_DEFAULT)]);

        return redirect()->to('/admin/users')->with('success', 'Kata laluan pengguna berjaya ditukar');
    }
}