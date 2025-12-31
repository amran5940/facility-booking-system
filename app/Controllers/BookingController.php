<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\FacilityModel;
use App\Models\FacilityCategoryModel;

class BookingController extends BaseController
{
    public function index()
    {
        $user = session('user');
        $bookingModel = new BookingModel();
        $allBookings = $bookingModel->select('bookings.*, facilities.name as facility_name, facilities.location, facility_categories.name as category_name, agencies.name as agency_name')
                                   ->join('facilities', 'facilities.id = bookings.facility_id')
                                   ->join('facility_categories', 'facility_categories.id = facilities.category_id')
                                   ->join('agencies', 'agencies.id = facilities.agency_id', 'left')
                                   ->where('bookings.user_id', $user['id'])
                                   ->orderBy('bookings.start_date', 'DESC')
                                   ->findAll();

        $currentBookings = [];
        $pastBookings = [];
        $now = date('Y-m-d H:i:s');

        foreach ($allBookings as $booking) {
            if ($booking['end_date'] >= $now) {
                $currentBookings[] = $booking;
            } else {
                $pastBookings[] = $booking;
            }
        }

        return view('bookings/index', [
            'currentBookings' => $currentBookings,
            'pastBookings' => $pastBookings
        ]);
    }

    public function adminIndex()
    {
        $bookingModel = new BookingModel();
        $bookings = $bookingModel->select('bookings.*, users.full_name as user_name, facilities.name as facility_name, agencies.name as agency_name')
                                ->join('users', 'users.id = bookings.user_id')
                                ->join('facilities', 'facilities.id = bookings.facility_id')
                                ->join('agencies', 'agencies.id = facilities.agency_id', 'left')
                                ->findAll();

        return view('bookings/admin_index', ['bookings' => $bookings]);
    }

    public function managerIndex()
    {
        $user = session('user');
        if ($user['role'] !== 'manager' || !$user['agency_id']) {
            return redirect()->to('/login');
        }

        $bookingModel = new BookingModel();
        $bookings = $bookingModel->select('bookings.*, users.full_name as user_name, facilities.name as facility_name')
                                ->join('users', 'users.id = bookings.user_id')
                                ->join('facilities', 'facilities.id = bookings.facility_id')
                                ->where('facilities.agency_id', $user['agency_id'])
                                ->findAll();

        return view('bookings/manager_index', ['bookings' => $bookings]);
    }

    public function create($facilityId)
    {
        $user = session('user');

        $facilityModel = new FacilityModel();
        $facility = $facilityModel->select('facilities.*, agencies.name as agency_name, facility_categories.name as category_name')
            ->join('agencies', 'agencies.id = facilities.agency_id', 'left')
            ->join('facility_categories', 'facility_categories.id = facilities.category_id', 'left')
            ->find($facilityId);

        if (!$facility) {
            return redirect()->to('/user')->with('error', 'Facility not found');
        }

        // Access control: public users can only book public facilities; agency users can book their own agency facilities and public facilities
        if ($facility['type'] === 'agency') {
            if (!isset($user['user_type']) || $user['user_type'] !== 'agency' || $facility['agency_id'] != $user['agency_id']) {
                return redirect()->to('/user')->with('error', 'Access denied');
            }
        }

        $categoryModel = new FacilityCategoryModel();
        $category = $categoryModel->find($facility['category_id']);

        // Get existing bookings for this facility
        $bookingModel = new BookingModel();
        $existingBookings = $bookingModel->where('facility_id', $facilityId)
                                         ->findAll();

        return view('bookings/create', [
            'facility' => $facility,
            'category' => $category,
            'existingBookings' => $existingBookings
        ]);
    }

    public function store()
    {
        $user = session('user');
        $facilityId = (int) $this->request->getPost('facility_id');

        $facilityModel = new FacilityModel();
        $facility = $facilityModel->find($facilityId);

        if (!$facility) {
            return redirect()->to('/user')->with('error', 'Facility not found');
        }

        // Check access
        if ($facility['type'] === 'agency' && ($user['user_type'] !== 'agency' || $facility['agency_id'] != $user['agency_id'])) {
            return redirect()->to('/user')->with('error', 'Access denied');
        }

        $data = [
            'user_id'    => $user['id'],
            'facility_id' => $facilityId,
            'start_date' => $this->request->getPost('start_date'),
            'end_date'   => $this->request->getPost('end_date'),
            'status'     => 'pending',
            'notes'      => trim((string) $this->request->getPost('notes')),
            'payment_gateway' => $this->request->getPost('payment_gateway'),
            'deposit_amount' => $this->request->getPost('deposit_amount'),
            'payment_status' => 'pending',
            'total_amount' => $this->request->getPost('total_amount') ?: null,
        ];

        $bookingModel = new BookingModel();
        if ($bookingModel->insert($data)) {
            return redirect()->to('/user/bookings')->with('success', 'Booking submitted');
        }

        return redirect()->back()->withInput()->with('errors', $bookingModel->errors());
    }

    public function approve($id)
    {
        $user = session('user');
        if (!in_array($user['role'], ['admin', 'manager'])) {
            return redirect()->to('/login');
        }

        $bookingModel = new BookingModel();
        $booking = $bookingModel->find($id);

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found');
        }

        // Check if manager owns the facility
        if ($user['role'] === 'manager') {
            $facilityModel = new FacilityModel();
            $facility = $facilityModel->find($booking['facility_id']);
            if (!$facility || $facility['agency_id'] != $user['agency_id']) {
                return redirect()->back()->with('error', 'Access denied');
            }
        }

        $bookingModel->update($id, ['status' => 'approved']);
        return redirect()->back()->with('success', 'Booking approved');
    }

    public function reject($id)
    {
        $user = session('user');
        if (!in_array($user['role'], ['admin', 'manager'])) {
            return redirect()->to('/login');
        }

        $bookingModel = new BookingModel();
        $booking = $bookingModel->find($id);

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found');
        }

        // Check if manager owns the facility
        if ($user['role'] === 'manager') {
            $facilityModel = new FacilityModel();
            $facility = $facilityModel->find($booking['facility_id']);
            if (!$facility || $facility['agency_id'] != $user['agency_id']) {
                return redirect()->back()->with('error', 'Access denied');
            }
        }

        $bookingModel->update($id, ['status' => 'cancelled']);
        return redirect()->back()->with('success', 'Booking rejected');
    }

    public function delete($id)
    {
        $user = session('user');
        if (!in_array($user['role'], ['admin', 'manager'])) {
            return redirect()->to('/login');
        }

        $bookingModel = new BookingModel();
        $booking = $bookingModel->find($id);

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found');
        }

        // Check if manager owns the facility
        if ($user['role'] === 'manager') {
            $facilityModel = new FacilityModel();
            $facility = $facilityModel->find($booking['facility_id']);
            if (!$facility || $facility['agency_id'] != $user['agency_id']) {
                return redirect()->back()->with('error', 'Access denied');
            }
        }

        $bookingModel->delete($id);
        return redirect()->back()->with('success', 'Booking deleted');
    }
}