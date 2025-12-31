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
        
        $facilityModel = new FacilityModel();
        $facilities = [];
        
        if ($user['role'] === 'manager' && $user['agency_id']) {
            // Manager: Show their agency facilities
            $facilities = $facilityModel->select('facilities.*, facility_categories.name as category_name')
                ->join('facility_categories', 'facility_categories.id = facilities.category_id')
                ->where('facilities.agency_id', $user['agency_id'])
                ->findAll();
        } elseif ($user['role'] === 'user') {
            // User: Show public facilities and agency facilities they can access
            $facilities = $facilityModel->select('facilities.*, facility_categories.name as category_name, agencies.name as agency_name')
                ->join('facility_categories', 'facility_categories.id = facilities.category_id')
                ->join('agencies', 'agencies.id = facilities.agency_id', 'left')
                ->where('facilities.status', 'active')
                ->findAll();
        } else {
            return redirect()->to('/login');
        }

        // Get primary image and image count for each facility
        $imageModel = new \App\Models\FacilityImageModel();
        foreach ($facilities as &$facility) {
            $primaryImage = $imageModel->where('facility_id', $facility['id'])
                                       ->where('is_primary', 1)
                                       ->first();
            $facility['primary_image'] = $primaryImage;
            
            $allImages = $imageModel->where('facility_id', $facility['id'])->findAll();
            $facility['image_count'] = count($allImages);
            $facility['images'] = $allImages;
            
            // Determine facility type for display
            $facility['facility_type'] = (!empty($facility['agency_id'])) ? 'agency' : 'public';
        }

        $categoryModel = new FacilityCategoryModel();
        $categories = $categoryModel->findAll();

        return view('facilities/index', ['facilities' => $facilities, 'categories' => $categories, 'user' => $user]);
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
            'latitude'    => $this->request->getPost('latitude') ?: null,
            'longitude'   => $this->request->getPost('longitude') ?: null,
            'pricing_type' => $this->request->getPost('pricing_type') ?: 'hourly',
            'price_per_hour' => (float) ($this->request->getPost('price_per_hour') ?? 0.00),
            'price_per_day' => (float) ($this->request->getPost('price_per_day') ?? 0.00),
            'created_by'  => $user['id'],
        ];

        $facilityModel = new FacilityModel();
        $facilityId = $facilityModel->insert($data);
        
        if ($facilityId) {
            // Handle image uploads
            $files = $this->request->getFileMultiple('facility_images');
            if ($files && count($files) > 0) {
                $imageModel = new \App\Models\FacilityImageModel();
                $uploadPath = FCPATH . 'uploads/facilities/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                foreach ($files as $index => $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $ext = pathinfo($file->getClientName(), PATHINFO_EXTENSION);
                        $mimeType = $file->getMimeType();
                        $newFileName = uniqid('facility_' . $facilityId . '_') . '.' . $ext;
                        $file->move($uploadPath, $newFileName);
                        $imageModel->insert([
                            'facility_id' => $facilityId,
                            'image_data' => $newFileName,
                            'image_type' => $mimeType,
                            'is_primary' => $index === 0 ? 1 : 0,
                            'sort_order' => $index * 10,
                        ]);
                    }
                }
            }
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

        $imageModel = new \App\Models\FacilityImageModel();
        $images = $imageModel->getByFacility((int) $id);

        return view('facilities/edit', [
            'facility' => $facility, 
            'categories' => $categories,
            'images' => $images
        ]);
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
            'latitude'    => $this->request->getPost('latitude') ?: null,
            'longitude'   => $this->request->getPost('longitude') ?: null,
            'pricing_type' => $this->request->getPost('pricing_type') ?: 'hourly',
            'price_per_hour' => (float) ($this->request->getPost('price_per_hour') ?? 0.00),
            'price_per_day' => (float) ($this->request->getPost('price_per_day') ?? 0.00),
        ];

        if ($facilityModel->update($id, $data)) {
            // Handle new image uploads
            $files = $this->request->getFileMultiple('facility_images');
            if ($files && count($files) > 0 && $files[0]->isValid()) {
                $imageModel = new \App\Models\FacilityImageModel();
                $existingCount = $imageModel->countByFacility((int) $id);
                $uploadPath = FCPATH . 'uploads/facilities/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                foreach ($files as $index => $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        if ($existingCount + $index + 1 > 5) break; // Max 5 images
                        
                        $ext = pathinfo($file->getClientName(), PATHINFO_EXTENSION);
                        $mimeType = $file->getMimeType();
                        $newFileName = uniqid('facility_' . $id . '_') . '.' . $ext;
                        $file->move($uploadPath, $newFileName);
                        $imageModel->insert([
                            'facility_id' => $id,
                            'image_data' => $newFileName,
                            'image_type' => $mimeType,
                            'is_primary' => ($existingCount === 0 && $index === 0) ? 1 : 0,
                            'sort_order' => ($existingCount + $index) * 10,
                        ]);
                    }
                }
            }
            
            $redirect = $user['role'] === 'admin' ? '/admin/facilities' : '/manager/facilities';
            return redirect()->to($redirect)->with('success', 'Facility updated');
        }

        return redirect()->back()->withInput()->with('errors', $facilityModel->errors());
    }

    public function deleteImage($imageId)
    {
        $user = session('user');
        if ($user['role'] !== 'manager' && $user['role'] !== 'admin') {
            return $this->response->setJSON(['success' => false]);
        }

        $imageModel = new \App\Models\FacilityImageModel();
        $image = $imageModel->find($imageId);
        
        if (!$image) {
            return $this->response->setJSON(['success' => false]);
        }

        // Check ownership for managers
        if ($user['role'] === 'manager') {
            $facilityModel = new FacilityModel();
            $facility = $facilityModel->find($image['facility_id']);
            if (!$facility || $facility['agency_id'] != $user['agency_id']) {
                return $this->response->setJSON(['success' => false]);
            }
        }

        // Delete file from filesystem
        $filePath = FCPATH . 'uploads/facilities/' . $image['image_data'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $imageModel->delete($imageId);
        return $this->response->setJSON(['success' => true]);
    }

    public function setPrimaryImage($imageId)
    {
        $user = session('user');
        if ($user['role'] !== 'manager' && $user['role'] !== 'admin') {
            return $this->response->setJSON(['success' => false]);
        }

        $imageModel = new \App\Models\FacilityImageModel();
        $image = $imageModel->find($imageId);
        
        if (!$image) {
            return $this->response->setJSON(['success' => false]);
        }

        // Check ownership for managers
        if ($user['role'] === 'manager') {
            $facilityModel = new FacilityModel();
            $facility = $facilityModel->find($image['facility_id']);
            if (!$facility || $facility['agency_id'] != $user['agency_id']) {
                return $this->response->setJSON(['success' => false]);
            }
        }

        $imageModel->setPrimary((int) $imageId, (int) $image['facility_id']);
        return $this->response->setJSON(['success' => true]);
    }

    public function getFacility($facilityId)
    {
        $user = session('user');
        if ($user['role'] !== 'manager' && $user['role'] !== 'admin') {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Unauthorized']);
        }

        $facilityModel = new FacilityModel();
        $facility = $facilityModel->find($facilityId);

        if (!$facility) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Facility not found']);
        }

        // Check ownership for managers
        if ($user['role'] === 'manager' && $facility['agency_id'] != $user['agency_id']) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Unauthorized']);
        }

        return $this->response->setJSON($facility);
    }

    public function getImages($facilityId)
    {
        $user = session('user');
        
        // For regular users, allow viewing images of any facility
        if ($user['role'] === 'user') {
            $imageModel = new \App\Models\FacilityImageModel();
            $images = $imageModel->getByFacility((int) $facilityId);
            return $this->response->setJSON(['images' => $images]);
        }
        
        // For admin and manager, check permissions
        if ($user['role'] !== 'manager' && $user['role'] !== 'admin') {
            return $this->response->setJSON(['images' => []]);
        }

        // Check ownership for managers
        if ($user['role'] === 'manager') {
            $facilityModel = new FacilityModel();
            $facility = $facilityModel->find($facilityId);
            if (!$facility || $facility['agency_id'] != $user['agency_id']) {
                return $this->response->setJSON(['images' => []]);
            }
        }

        $imageModel = new \App\Models\FacilityImageModel();
        $images = $imageModel->getByFacility((int) $facilityId);
        
        // Return only metadata, not the actual blob data
        $result = array_map(function($img) {
            return [
                'id' => $img['id'],
                'is_primary' => $img['is_primary'],
                'image_type' => $img['image_type']
            ];
        }, $images);
        
        return $this->response->setJSON(['images' => $result]);
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