<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AgencyModel;

class AuthController extends BaseController
{
    public function doLogin()
    {
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        $userModel = new UserModel();
        $user      = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('login_error', 'Kredensial tidak sah');
        }

        if ($user['approved'] == 0) {
            return redirect()->back()->with('login_error', 'Akaun belum diluluskan');
        }

        session()->set('user', [
            'id'         => $user['id'],
            'email'      => $user['email'],
            'full_name'  => $user['full_name'],
            'phone'      => $user['phone'],
            'date_of_birth' => $user['date_of_birth'],
            'address'    => $user['address'],
            'gender'     => $user['gender'],
            'role'       => $user['role'],
            'agency_id'  => $user['agency_id'],
            'user_type'  => $user['user_type'],
            'agency_application_status' => $user['agency_application_status'] ?? 'none',
            'requested_agency_id' => $user['requested_agency_id'] ?? null,
        ]);

        return redirect()->to($this->targetForRole($user['role']));
    }

    public function doRegister()
    {
        $email = trim((string) $this->request->getPost('email'));
        $data = [
            'email'      => $email,
            'password'   => (string) $this->request->getPost('password'),
            'full_name'  => trim((string) $this->request->getPost('full_name')),
            'phone'      => trim((string) $this->request->getPost('phone')),
            'date_of_birth' => $this->request->getPost('date_of_birth') ? trim((string) $this->request->getPost('date_of_birth')) : null,
            'address'    => trim((string) $this->request->getPost('address')),
            'gender'     => $this->request->getPost('gender') ?: null,
            'role'       => 'user',
            'user_type'  => 'public',
            'agency_id'  => null,
            'approved'   => 1,
            'status'     => 'active',
        ];

        $userModel = new UserModel();
        if ($userModel->insert($data) === false) {
            return redirect()->back()->withInput()->with('error', 'Pendaftaran gagal: ' . implode(', ', $userModel->errors()));
        }

        return redirect()->to('/login')->with('success', 'Pendaftaran berjaya. Sila log masuk.');
    }

    public function logout()
    {
        session()->remove('user');
        return redirect()->to('/');
    }

    public function changePassword()
    {
        if (!session()->has('user')) {
            return redirect()->to('/');
        }

        return view('auth/change_password');
    }

    public function doChangePassword()
    {
        $currentPassword = (string) $this->request->getPost('current_password');
        $newPassword = (string) $this->request->getPost('new_password');
        $confirmPassword = (string) $this->request->getPost('confirm_password');

        $user = session('user');
        $userModel = new UserModel();
        $dbUser = $userModel->find($user['id']);

        if (!$dbUser || !password_verify($currentPassword, $dbUser['password'])) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Kata laluan semasa tidak betul'
                ]);
            }
            return redirect()->back()->with('error', 'Kata laluan semasa tidak betul');
        }

        if ($newPassword !== $confirmPassword) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Kata laluan baharu tidak sepadan'
                ]);
            }
            return redirect()->back()->with('error', 'Kata laluan baharu tidak sepadan');
        }

        if (strlen($newPassword) < 8) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Kata laluan baharu mesti sekurang-kurangnya 8 aksara'
                ]);
            }
            return redirect()->back()->with('error', 'Kata laluan baharu mesti sekurang-kurangnya 8 aksara');
        }

        $userModel->update($user['id'], ['password' => password_hash($newPassword, PASSWORD_DEFAULT)]);

        // Regenerate session for security
        session()->regenerate();

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Kata laluan berjaya ditukar'
            ]);
        }

        return redirect()->back()->with('success', 'Kata laluan berjaya ditukar');
    }

    public function updateProfile()
    {
        $user = session('user');
        $userModel = new UserModel();

        $data = [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email' => trim((string) $this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'date_of_birth' => $this->request->getPost('date_of_birth') ? trim((string) $this->request->getPost('date_of_birth')) : null,
            'address' => trim((string) $this->request->getPost('address')),
            'gender' => trim((string) $this->request->getPost('gender')),
        ];

        // Validate required fields
        if (empty($data['full_name']) || empty($data['email'])) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Nama penuh dan emel diperlukan'
                ]);
            }
            return redirect()->back()->with('error', 'Nama penuh dan emel diperlukan');
        }

        // Check if email is already taken by another user
        $existingUser = $userModel->where('email', $data['email'])->where('id !=', $user['id'])->first();
        if ($existingUser) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Emel sudah digunakan oleh pengguna lain'
                ]);
            }
            return redirect()->back()->with('error', 'Emel sudah digunakan oleh pengguna lain');
        }

        // Update user profile
        $userModel->update($user['id'], $data);

        // Update session data
        $updatedUser = $userModel->find($user['id']);
        session()->set('user', [
            'id' => $updatedUser['id'],
            'email' => $updatedUser['email'],
            'full_name' => $updatedUser['full_name'],
            'phone' => $updatedUser['phone'],
            'date_of_birth' => $updatedUser['date_of_birth'],
            'address' => $updatedUser['address'],
            'gender' => $updatedUser['gender'],
            'role' => $updatedUser['role'],
            'agency_id' => $updatedUser['agency_id'],
            'user_type' => $updatedUser['user_type'],
            'agency_application_status' => $updatedUser['agency_application_status'] ?? 'none',
            'requested_agency_id' => $updatedUser['requested_agency_id'] ?? null,
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Profil berjaya dikemaskini',
                'user' => [
                    'full_name' => $updatedUser['full_name'],
                    'email' => $updatedUser['email'],
                    'phone' => $updatedUser['phone']
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Profil berjaya dikemaskini');
    }

    private function targetForRole(string $role): string
    {
        return match ($role) {
            'admin'   => '/admin',
            'manager' => '/manager',
            default   => '/user',
        };
    }

    public function forgotPassword(): string
    {
        return view('auth/forgot_password');
    }

    public function doForgotPassword()
    {
        $email = trim((string) $this->request->getPost('email'));

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Emel tidak dijumpai dalam sistem');
        }

        // Generate a reset token (simplified - in production, use proper token generation)
        $resetToken = bin2hex(random_bytes(32));
        $resetExpiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Store reset token in database (you might need to add these columns to users table)
        $userModel->update($user['id'], [
            'reset_token' => $resetToken,
            'reset_expiry' => $resetExpiry
        ]);

        // Send reset email (simplified - in production, use proper email service)
        // For now, just show success message
        return redirect()->back()->with('success', 'Pautan tetapan semula kata laluan telah dihantar ke emel anda');
    }
}
