<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class AgencyPaymentGatewayModel extends Model
{
    protected $table         = 'agency_payment_gateways';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'agency_id',
        'payment_gateway_id',
        'use_own_gateway',
        'gateway_name',
        'gateway_code',
        'api_key',
        'api_secret',
        'merchant_id',
        'config',
        'is_active',
    ];
    protected $useTimestamps = true;
    protected $validationRules = [
        'agency_id' => 'required|integer',
        'payment_gateway_id' => 'permit_empty|integer',
        'use_own_gateway' => 'permit_empty|in_list[0,1]',
        'gateway_name' => 'permit_empty|max_length[255]',
        'gateway_code' => 'permit_empty|max_length[50]',
        'api_key' => 'permit_empty',
        'api_secret' => 'permit_empty',
        'merchant_id' => 'permit_empty',
        'config' => 'permit_empty',
        'is_active' => 'permit_empty|in_list[0,1]',
    ];
    
    public function getAgencyGateway(int $agencyId)
    {
        return $this->where('agency_id', $agencyId)
                    ->where('is_active', 1)
                    ->first();
    }
    
    public function getGatewayWithDetails(int $agencyId)
    {
        $agencyGateway = $this->getAgencyGateway($agencyId);
        
        if (!$agencyGateway) {
            return null;
        }
        
        // If using own gateway
        if ($agencyGateway['use_own_gateway']) {
            return $agencyGateway;
        }
        
        // If using admin gateway, get gateway details
        if ($agencyGateway['payment_gateway_id']) {
            $gatewayModel = new PaymentGatewayModel();
            $gateway = $gatewayModel->find($agencyGateway['payment_gateway_id']);
            
            if ($gateway) {
                $agencyGateway['gateway_details'] = $gateway;
            }
        }
        
        return $agencyGateway;
    }
}
