<?php

namespace App\Controllers;

use App\Models\FacilityModel;
use App\Models\AgencyModel;

class Home extends BaseController
{
    public function index()
    {
        $user = session('user');
        if ($user) {
            return redirect()->to('/dashboard');
        }

        // Load public facilities and agencies
        $facilityModel = new FacilityModel();
        $agencyModel = new AgencyModel();

        $agencies = $agencyModel->where('status', 'active')->findAll();
        
        // Group facilities by agency
        $facilitiesByAgency = [];
        foreach ($agencies as $agency) {
            $facilities = $facilityModel->where('agency_id', $agency['id'])
                                      ->where('type', 'public')
                                      ->where('status', 'active')
                                      ->findAll();
            $facilitiesByAgency[$agency['id']] = $facilities;
        }

        return view('home/index', ['agencies' => $agencies, 'facilitiesByAgency' => $facilitiesByAgency]);
    }
}
