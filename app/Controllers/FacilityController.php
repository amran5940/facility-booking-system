<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\FacilityModel;
use App\Models\FacilityCategoryModel;
use App\Models\BookingModel;
use App\Models\BlockedDateModel;

class FacilityController extends BaseController
{
    public function adminIndex()
    {
        $facilityModel = new FacilityModel();
        $facilities = $facilityModel->select('facilities.*, facility_categories.name as category_name, agencies.name as agency_name')
            ->join('facility_categories', 'facility_categories.id = facilities.category_id')
            ->join('agencies', 'agencies.id = facilities.agency_id', 'left')
            ->findAll();

        return view('facilities/admin_index', ['facilities' => $facilities]);
    }

    public function index()
    {
        $user = session('user');
        if ($user['role'] !== 'manager' || !$user['agency_id']) {
            return redirect()->to('/login');
        }

        $facilityModel = new FacilityModel();
        $facilities = $facilityModel->select('facilities.*, facility_categories.name as category_name')
            ->join('facility_categories', 'facility_categories.id = facilities.category_id')
            ->where('facilities.agency_id', $user['agency_id'])
            ->findAll();

        $categoryModel = new FacilityCategoryModel();
        $categories = $categoryModel->findAll();

        return view('facilities/index', ['facilities' => $facilities, 'categories' => $categories]);
    }

    public function create()
    {
        $user = session('user');
        if ($user['role'] !== 'manager' || !$user['agency_id']) {
            return redirect()->to('/login');
        }

        $categoryModel = new FacilityCategoryModel();
        $categories = $categoryModel->findAll();

        return view('facilities/create', ['categories' => $categories]);
    }

    public function store()
    {
        $user = session('user');
        if ($user['role'] !== 'manager' || !$user['agency_id']) {
            return redirect()->to('/login');
        }

        $data = [
            'name'        => trim((string) $this->request->getPost('name')),
            'description' => trim((string) $this->request->getPost('description')),
            'category_id' => (int) $this->request->getPost('category_id'),
            'agency_id'   => $user['agency_id'],
            'type'        => $this->request->getPost('type'),
            'status'      => 'active',
            'capacity'    => (int) $this->request->getPost('capacity'),
            'location'    => trim((string) $this->request->getPost('location')),
            'created_by'  => $user['id'],
        ];

        $facilityModel = new FacilityModel();
        if ($facilityModel->insert($data)) {
            return redirect()->to('/manager/facilities')->with('success', 'Facility created');
        }

        return redirect()->back()->withInput()->with('errors', $facilityModel->errors());
    }

    public function edit($id)
    {
        $user = session('user');
        if ($user['role'] !== 'manager' && $user['role'] !== 'admin') {
            return redirect()->to('/login');
        }

        $facilityModel = new FacilityModel();
        $facility = $facilityModel->find($id);

        if (!$facility) {
            return redirect()->back()->with('error', 'Facility not found');
        }

        // For manager, check ownership
        if ($user['role'] === 'manager' && $facility['agency_id'] != $user['agency_id']) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $facilityCategoryModel = new FacilityCategoryModel();
        $categories = $facilityCategoryModel->findAll();

        return view('facilities/edit', ['facility' => $facility, 'categories' => $categories]);
    }

    public function update($id)
    {
        $user = session('user');
        if ($user['role'] !== 'manager' && $user['role'] !== 'admin') {
            return redirect()->to('/login');
        }

        $facilityModel = new FacilityModel();
        $facility = $facilityModel->find($id);

        if (!$facility) {
            return redirect()->back()->with('error', 'Facility not found');
        }

        // For manager, check ownership
        if ($user['role'] === 'manager' && $facility['agency_id'] != $user['agency_id']) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $data = [
            'name'        => trim((string) $this->request->getPost('name')),
            'description' => trim((string) $this->request->getPost('description')),
            'category_id' => (int) $this->request->getPost('category_id'),
            'type'        => $this->request->getPost('type'),
            'status'      => $this->request->getPost('status'),
            'capacity'    => (int) $this->request->getPost('capacity'),
            'location'    => trim((string) $this->request->getPost('location')),
        ];

        if ($facilityModel->update($id, $data)) {
            $redirect = $user['role'] === 'admin' ? '/admin/facilities' : '/manager/facilities';
            return redirect()->to($redirect)->with('success', 'Facility updated');
        }

        return redirect()->back()->withInput()->with('errors', $facilityModel->errors());
    }

    public function delete($id)
    {
        $user = session('user');
        if ($user['role'] !== 'manager' && $user['role'] !== 'admin') {
            return redirect()->to('/login');
        }

        $facilityModel = new FacilityModel();
        $facility = $facilityModel->find($id);

        if (!$facility) {
            return redirect()->back()->with('error', 'Facility not found');
        }

        // For manager, check ownership
        if ($user['role'] === 'manager' && $facility['agency_id'] != $user['agency_id']) {
            return redirect()->back()->with('error', 'Access denied');
        }

        // Check if facility has bookings
        $bookingModel = new BookingModel();
        $hasBookings = $bookingModel->where('facility_id', $id)->countAllResults() > 0;

        if ($hasBookings) {
            return redirect()->back()->with('error', 'Cannot delete facility with existing bookings');
        }

        if ($facilityModel->delete($id)) {
            $redirect = $user['role'] === 'admin' ? '/admin/facilities' : '/manager/facilities';
            return redirect()->to($redirect)->with('success', 'Facility deleted');
        }

        return redirect()->back()->with('error', 'Failed to delete facility');
    }

    public function getBookings($id)
    {
        try {
            $user = session('user');
            if (!$user || ($user['role'] !== 'manager' && $user['role'] !== 'admin')) {
                return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
            }

            $facilityModel = new FacilityModel();
            $facility = $facilityModel->find($id);

            if (!$facility) {
                return $this->response->setJSON(['error' => 'Facility not found'])->setStatusCode(404);
            }

            // For manager, check ownership
            if ($user['role'] === 'manager' && $facility['agency_id'] != $user['agency_id']) {
                return $this->response->setJSON(['error' => 'Access denied'])->setStatusCode(403);
            }

            $bookingModel = new BookingModel();
            $bookings = $bookingModel->where('facility_id', $id)
                                     ->findAll();

            $blockedDateModel = new BlockedDateModel();
            $blockedDates = $blockedDateModel->where('facility_id', $id)
                                             ->findAll();

            return $this->response->setJSON([
                'bookings' => $bookings ?? [],
                'blocked_dates' => $blockedDates ?? []
            ]);
        } catch (\Exception $e) {
            log_message('error', 'getBookings error: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Server error', 'message' => $e->getMessage()])->setStatusCode(500);
        }
    }

    public function blockDates()
    {
        $user = session('user');
        if ($user['role'] !== 'manager' && $user['role'] !== 'admin') {
            return redirect()->to('/login');
        }

        $facilityId = (int) $this->request->getPost('facility_id');
        $blockedDatesJson = $this->request->getPost('blocked_dates');
        $reason = trim((string) $this->request->getPost('reason'));
        $action = $this->request->getPost('action');

        $facilityModel = new FacilityModel();
        $facility = $facilityModel->find($facilityId);

        if (!$facility) {
            return redirect()->back()->with('error', 'Facility not found');
        }

        // For manager, check ownership
        if ($user['role'] === 'manager' && $facility['agency_id'] != $user['agency_id']) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $blockedDateModel = new BlockedDateModel();

        // Delete single blocked date
        if ($action === 'delete') {
            $dateToDelete = $this->request->getPost('blocked_date');
            if (!$dateToDelete) {
                $msg = 'No date to delete';
                if ($this->request->isAJAX()) {
                    return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => $msg]);
                }
                return redirect()->back()->with('error', $msg);
            }

            $deleted = $blockedDateModel->where([
                'facility_id' => $facilityId,
                'blocked_date' => $dateToDelete
            ])->delete();

            $message = $deleted ? 'Tarikh di-block dipadam' : 'Tarikh tidak ditemui';
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => (bool) $deleted, 'message' => $message]);
            }
            return redirect()->to('/manager/facilities')->with('success', $message);
        }

        $blockedDates = json_decode($blockedDatesJson, true);
        if (empty($blockedDates)) {
            $msg = 'No dates selected';
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => $msg]);
            }
            return redirect()->back()->with('error', $msg);
        }

        // Insert or update each blocked date
        $inserted = 0;
        $updated = 0;
        foreach ($blockedDates as $dateStr) {
            // Check if date is already blocked
            $existing = $blockedDateModel->where([
                'facility_id' => $facilityId,
                'blocked_date' => $dateStr
            ])->first();

            if (!$existing) {
                $blockedDateModel->insert([
                    'facility_id' => $facilityId,
                    'blocked_date' => $dateStr,
                    'reason' => $reason,
                    'created_by' => $user['id']
                ]);
                $inserted++;
            } else {
                $existingReason = (string) ($existing['reason'] ?? '');
                // Only update when reason provided and changed
                if ($reason !== '' && $reason !== $existingReason) {
                    $blockedDateModel->update($existing['id'], [
                        'facility_id' => $facilityId,
                        'blocked_date' => $dateStr,
                        'reason' => $reason,
                        'created_by' => $existing['created_by'] ?? $user['id'],
                    ]);
                    $updated++;
                }
            }
        }

        if ($inserted > 0 && $updated > 0) {
            $message = "$inserted tarikh baru di-block, $updated tarikh dikemas kini";
        } elseif ($inserted > 0) {
            $message = "$inserted tarikh berjaya di-block";
        } elseif ($updated > 0) {
            $message = "$updated tarikh berjaya dikemas kini";
        } else {
            $message = 'Tiada perubahan (tarikh sudah di-block)';
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => $message,
                'inserted' => $inserted,
                'updated' => $updated,
            ]);
        }

        return redirect()->to('/manager/facilities')->with('success', $message);
    }
}