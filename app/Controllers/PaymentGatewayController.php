<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\PaymentGatewayModel;
use App\Models\AgencyPaymentGatewayModel;

class PaymentGatewayController extends BaseController
{
    // Admin: List all payment gateways
    public function index()
    {
        $user = session('user');
        if ($user['role'] !== 'admin') {
            return redirect()->to('/login');
        }

        $model = new PaymentGatewayModel();
        $gateways = $model->findAll();

        return view('payment_gateways/index', [
            'gateways' => $gateways
        ]);
    }

    // Admin: Create payment gateway
    public function create()
    {
        $user = session('user');
        if ($user['role'] !== 'admin') {
            return redirect()->to('/login');
        }

        return view('payment_gateways/create');
    }

    // Admin: Store payment gateway
    public function store()
    {
        $user = session('user');
        if ($user['role'] !== 'admin') {
            return redirect()->to('/login');
        }

        $model = new PaymentGatewayModel();
        
        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'code' => trim((string) $this->request->getPost('code')),
            'description' => trim((string) $this->request->getPost('description')),
            'is_active' => (int) $this->request->getPost('is_active'),
        ];

        if ($model->insert($data)) {
            return redirect()->to('/admin/payment-gateways')->with('success', 'Payment gateway created successfully');
        }

        return redirect()->back()->with('error', 'Failed to create payment gateway');
    }

    // Admin: Edit payment gateway
    public function edit($id)
    {
        $user = session('user');
        if ($user['role'] !== 'admin') {
            return redirect()->to('/login');
        }

        $model = new PaymentGatewayModel();
        $gateway = $model->find($id);

        if (!$gateway) {
            return redirect()->back()->with('error', 'Payment gateway not found');
        }

        return view('payment_gateways/edit', [
            'gateway' => $gateway
        ]);
    }

    // Admin: Update payment gateway
    public function update($id)
    {
        $user = session('user');
        if ($user['role'] !== 'admin') {
            return redirect()->to('/login');
        }

        $model = new PaymentGatewayModel();
        
        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'code' => trim((string) $this->request->getPost('code')),
            'description' => trim((string) $this->request->getPost('description')),
            'is_active' => (int) $this->request->getPost('is_active'),
        ];

        if ($model->update($id, $data)) {
            return redirect()->to('/admin/payment-gateways')->with('success', 'Payment gateway updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update payment gateway');
    }

    // Admin: Delete payment gateway
    public function delete($id)
    {
        $user = session('user');
        if ($user['role'] !== 'admin') {
            return redirect()->to('/login');
        }

        $model = new PaymentGatewayModel();
        
        if ($model->delete($id)) {
            return redirect()->to('/admin/payment-gateways')->with('success', 'Payment gateway deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete payment gateway');
    }

    // Manager: Agency payment settings
    public function agencySettings()
    {
        $user = session('user');
        if ($user['role'] !== 'manager' || !$user['agency_id']) {
            return redirect()->to('/login');
        }

        $gatewayModel = new PaymentGatewayModel();
        $agencyGatewayModel = new AgencyPaymentGatewayModel();

        $adminGateways = $gatewayModel->where('is_active', 1)->findAll();
        $agencyGateway = $agencyGatewayModel->getAgencyGateway((int) $user['agency_id']);

        return view('payment_gateways/agency_settings', [
            'adminGateways' => $adminGateways,
            'agencyGateway' => $agencyGateway
        ]);
    }

    // Manager: Update agency payment settings
    public function updateAgencySettings()
    {
        $user = session('user');
        if ($user['role'] !== 'manager' || !$user['agency_id']) {
            return redirect()->to('/login');
        }

        $model = new AgencyPaymentGatewayModel();
        $useOwnGateway = (int) $this->request->getPost('use_own_gateway');

        $data = [
            'agency_id' => $user['agency_id'],
            'use_own_gateway' => $useOwnGateway,
            'is_active' => 1,
        ];

        if ($useOwnGateway) {
            // Using own gateway
            $data['payment_gateway_id'] = null;
            $data['gateway_name'] = trim((string) $this->request->getPost('gateway_name'));
            $data['gateway_code'] = trim((string) $this->request->getPost('gateway_code'));
            $data['api_key'] = trim((string) $this->request->getPost('api_key'));
            $data['api_secret'] = trim((string) $this->request->getPost('api_secret'));
            $data['merchant_id'] = trim((string) $this->request->getPost('merchant_id'));
        } else {
            // Using admin gateway
            $data['payment_gateway_id'] = (int) $this->request->getPost('payment_gateway_id');
            $data['gateway_name'] = null;
            $data['gateway_code'] = null;
            $data['api_key'] = null;
            $data['api_secret'] = null;
            $data['merchant_id'] = null;
        }

        // Check if agency already has settings
        $existing = $model->getAgencyGateway((int) $user['agency_id']);

        if ($existing) {
            $model->update($existing['id'], $data);
        } else {
            $model->insert($data);
        }

        return redirect()->to('/manager/payment-settings')->with('success', 'Payment settings updated successfully');
    }
}
