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
        
        // Group facilities by agency and get primary images
        $facilitiesByAgency = [];
        $imageModel = new \App\Models\FacilityImageModel();
        
        foreach ($agencies as $agency) {
            $facilities = $facilityModel->where('agency_id', $agency['id'])
                                      ->where('type', 'public')
                                      ->where('status', 'active')
                                      ->findAll();
            
            // Get primary image for each facility
            foreach ($facilities as &$facility) {
                $primaryImage = $imageModel->where('facility_id', $facility['id'])
                                           ->where('is_primary', 1)
                                           ->first();
                $facility['primary_image'] = $primaryImage;
            }
            
            $facilitiesByAgency[$agency['id']] = $facilities;
        }

        return view('home/index', ['agencies' => $agencies, 'facilitiesByAgency' => $facilitiesByAgency]);
    }
}
