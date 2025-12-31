<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class PaymentGatewayModel extends Model
{
    protected $table         = 'payment_gateways';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'name',
        'code',
        'description',
        'api_key',
        'api_secret',
        'merchant_id',
        'config',
        'is_active',
    ];
    protected $useTimestamps = true;
    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'code' => 'required|max_length[50]|is_unique[payment_gateways.code,id,{id}]',
        'description' => 'permit_empty',
        'api_key' => 'permit_empty',
        'api_secret' => 'permit_empty',
        'merchant_id' => 'permit_empty',
        'config' => 'permit_empty',
        'is_active' => 'permit_empty|in_list[0,1]',
    ];
}
