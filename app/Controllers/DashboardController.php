<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AgencyModel;
use App\Models\FacilityModel;
use App\Models\FacilityCategoryModel;

class DashboardController extends BaseController
{
    public function index()
    {
        return redirect()->to('/login');
    }

    public function admin()
    {
        $userModel = new UserModel();
        $agencyModel = new AgencyModel();
        $facilityModel = new FacilityModel();
        $facilityCategoryModel = new FacilityCategoryModel();

        // Get basic counts
        $total_users = $userModel->countAll();
        $total_agencies = $agencyModel->countAll();
        $total_managers = $userModel->where('role', 'manager')->countAllResults();
        $total_facilities = $facilityModel->countAll();

        // Get additional statistics
        $active_facilities = $facilityModel->where('status', 'active')->countAllResults();
        $inactive_facilities = $facilityModel->where('status', 'inactive')->countAllResults();
        $assigned_managers = $userModel->where('role', 'manager')->where('agency_id IS NOT NULL')->countAllResults();
        $unassigned_managers = $total_managers - $assigned_managers;

        // Get recent bookings count (last 30 days)
        $bookingModel = new \App\Models\BookingModel();
        $recent_bookings = $bookingModel->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))->countAllResults();

        // Get facility distribution by category
        $facility_stats = $facilityModel->select('facility_categories.name as category_name, COUNT(*) as count')
            ->join('facility_categories', 'facility_categories.id = facilities.category_id')
            ->groupBy('facilities.category_id')
            ->findAll();

        // Get available facilities by agency
        $available_facilities = $facilityModel->select('facilities.*, agencies.name as agency_name, facility_categories.name as category_name')
            ->join('agencies', 'agencies.id = facilities.agency_id')
            ->join('facility_categories', 'facility_categories.id = facilities.category_id')
            ->where('facilities.status', 'active')
            ->orderBy('agencies.name')
            ->findAll();

        $data = [
            'total_users' => $total_users,
            'total_agencies' => $total_agencies,
            'total_managers' => $total_managers,
            'total_facilities' => $total_facilities,
            'active_facilities' => $active_facilities,
            'inactive_facilities' => $inactive_facilities,
            'assigned_managers' => $assigned_managers,
            'unassigned_managers' => $unassigned_managers,
            'recent_bookings' => $recent_bookings,
            'facility_stats' => $facility_stats,
            'available_facilities' => $available_facilities,
        ];

        return view('dashboards/admin', $data);
    }

    public function manager()
    {
        $user = session('user');
        $agencyModel = new AgencyModel();
        $facilityModel = new FacilityModel();
        $userModel = new UserModel();

        $agency = $agencyModel->find($user['agency_id']);

        // Get statistics for manager's agency
        $total_facilities = $facilityModel->where('agency_id', $user['agency_id'])->countAllResults();
        $active_facilities = $facilityModel->where('agency_id', $user['agency_id'])->where('status', 'active')->countAllResults();
        $inactive_facilities = $total_facilities - $active_facilities;

        // Get booking statistics
        $bookingModel = new \App\Models\BookingModel();
        $total_bookings = $bookingModel->select('bookings.*')
            ->join('facilities', 'facilities.id = bookings.facility_id')
            ->where('facilities.agency_id', $user['agency_id'])
            ->countAllResults();

        $pending_bookings = $bookingModel->select('bookings.*')
            ->join('facilities', 'facilities.id = bookings.facility_id')
            ->where('facilities.agency_id', $user['agency_id'])
            ->where('bookings.status', 'pending')
            ->countAllResults();

        $approved_bookings = $bookingModel->select('bookings.*')
            ->join('facilities', 'facilities.id = bookings.facility_id')
            ->where('facilities.agency_id', $user['agency_id'])
            ->where('bookings.status', 'approved')
            ->countAllResults();

        // Get recent bookings (last 7 days)
        $recent_bookings = $bookingModel->select('bookings.*, users.full_name as user_name, facilities.name as facility_name')
            ->join('facilities', 'facilities.id = bookings.facility_id')
            ->join('users', 'users.id = bookings.user_id')
            ->where('facilities.agency_id', $user['agency_id'])
            ->where('bookings.created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))
            ->orderBy('bookings.created_at', 'DESC')
            ->findAll();

        // Get public users that can be assigned to this agency
        $public_users = $userModel->where('user_type', 'public')
            ->where('role', 'user')
            ->findAll();

        return view('dashboards/manager', [
            'agency' => $agency,
            'total_facilities' => $total_facilities,
            'active_facilities' => $active_facilities,
            'inactive_facilities' => $inactive_facilities,
            'total_bookings' => $total_bookings,
            'pending_bookings' => $pending_bookings,
            'approved_bookings' => $approved_bookings,
            'recent_bookings' => $recent_bookings,
            'public_users' => $public_users,
        ]);
    }

    public function unassignManager()
    {
        $user = session('user');
        if ($user['role'] !== 'manager') {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $userModel->update($user['id'], ['agency_id' => null]);

        return redirect()->to('/')->with('success', 'You have been unassigned from the agency');
    }

    public function user()
    {
        $sessionUser = session('user');
        if (!$sessionUser) {
            return redirect()->to('/login');
        }

        // Always fetch fresh user info so admin edits reflect on dashboard
        $userModel = new UserModel();
        $sessionUserId = $sessionUser['id'] ?? null;
        if (!$sessionUserId) {
            session()->destroy();
            return redirect()->to('/login');
        }

        $user = $userModel->find($sessionUserId);
        if (!$user) {
            session()->destroy();
            return redirect()->to('/login');
        }
        session()->set('user', $user);

        $agencyModel = new AgencyModel();
        $facilityModel = new FacilityModel();

        // Get all agencies (needed for lookups)
        $agencies = $agencyModel->findAll();

        // Facilities grouped for display
        $agencyFacilities = [];
        $imageModel = new \App\Models\FacilityImageModel();

        if (($user['user_type'] ?? '') === 'agency') {
            // Agency user: show all facilities (public + agency) from all agencies
            foreach ($agencies as $agency) {
                $facilities = $facilityModel->select('facilities.*, facility_categories.name as category_name')
                    ->join('facility_categories', 'facility_categories.id = facilities.category_id', 'left')
                    ->where('facilities.agency_id', $agency['id'])
                    ->where('facilities.status', 'active')
                    ->findAll();
                
                // Get primary image and image count for each facility
                foreach ($facilities as &$facility) {
                    $primaryImage = $imageModel->where('facility_id', $facility['id'])
                                               ->where('is_primary', 1)
                                               ->first();
                    $facility['primary_image'] = $primaryImage;
                    $facility['image_count'] = $imageModel->where('facility_id', $facility['id'])->countAllResults();
                }
                
                if (!empty($facilities)) {
                    $agencyFacilities[] = [
                        'agency' => $agency,
                        'facilities' => $facilities,
                    ];
                }
            }
        }

        // Public facilities (for public users)
        $publicFacilities = [];
        $publicFacilitiesByAgency = [];
        if (($user['user_type'] ?? 'public') === 'public') {
            $publicFacilities = $facilityModel->select('facilities.*, facility_categories.name as category_name, agencies.name as agency_name')
                ->join('facility_categories', 'facility_categories.id = facilities.category_id', 'left')
                ->join('agencies', 'agencies.id = facilities.agency_id', 'left')
                ->where('facilities.type', 'public')
                ->where('facilities.status', 'active')
                ->findAll();

            // Get primary image and image count for each public facility
            foreach ($publicFacilities as &$facility) {
                $primaryImage = $imageModel->where('facility_id', $facility['id'])
                                           ->where('is_primary', 1)
                                           ->first();
                $facility['primary_image'] = $primaryImage;
                $facility['image_count'] = $imageModel->where('facility_id', $facility['id'])->countAllResults();
            }

            // Group public facilities by offering agency (if any)
            foreach ($publicFacilities as $facility) {
                $agencyKey = $facility['agency_id'] ?? 'public_general';
                if (!isset($publicFacilitiesByAgency[$agencyKey])) {
                    $publicFacilitiesByAgency[$agencyKey] = [
                        'agency' => [
                            'id' => $facility['agency_id'],
                            'name' => $facility['agency_name'] ?? 'Fasiliti Awam Umum',
                        ],
                        'facilities' => []
                    ];
                }
                $publicFacilitiesByAgency[$agencyKey]['facilities'][] = $facility;
            }
        }

        if (($user['user_type'] ?? '') === 'agency') {
            $userAgencyFacilities = $facilityModel->select('facilities.*, facility_categories.name as category_name')
                ->join('facility_categories', 'facility_categories.id = facilities.category_id', 'left')
                ->where('facilities.agency_id', $user['agency_id'])
                ->where('facilities.type', 'agency')
                ->where('facilities.status', 'active')
                ->findAll();
            
            // Get primary image and image count for user agency facilities
            foreach ($userAgencyFacilities as &$facility) {
                $primaryImage = $imageModel->where('facility_id', $facility['id'])
                                           ->where('is_primary', 1)
                                           ->first();
                $facility['primary_image'] = $primaryImage;
                $facility['image_count'] = $imageModel->where('facility_id', $facility['id'])->countAllResults();
            }
            
            $publicFacilities = array_merge($publicFacilities, $userAgencyFacilities);
        }

        return view('dashboards/user', [
            'agencyFacilities' => $agencyFacilities,
            'publicFacilities' => $publicFacilities,
            'publicFacilitiesByAgency' => $publicFacilitiesByAgency,
            'agencies' => $agencies,
            'userType' => $user['user_type'] ?? 'public',
        ]);
    }

    public function assignUserToAgency($userId)
    {
        $manager = session('user');
        if ($manager['role'] !== 'manager') {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user || $user['user_type'] !== 'public' || $user['role'] !== 'user') {
            return redirect()->back()->with('error', 'Pengguna tidak sah atau sudah ditugaskan kepada agensi lain.');
        }

        $data = [
            'user_type' => 'agency',
            'agency_id' => $manager['agency_id'],
            'approved' => 1,
            'agency_application_status' => 'approved',
        ];

        if ($userModel->update($userId, $data)) {
            return redirect()->back()->with('success', 'Pengguna telah berjaya ditugaskan kepada agensi.');
        }

        return redirect()->back()->with('error', 'Gagal menugaskan pengguna kepada agensi.');
    }
}
