<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table         = 'bookings';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'user_id',
        'facility_id',
        'start_date',
        'end_date',
        'status',
        'notes',
        'payment_gateway',
        'deposit_amount',
        'payment_status',
        'total_amount',
    ];
    protected $useTimestamps = true;
    protected $validationRules = [
        'user_id' => 'required|integer',
        'facility_id' => 'required|integer',
        'start_date' => 'required|valid_date',
        'end_date' => 'required|valid_date',
        'status' => 'required|in_list[pending,approved,cancelled]',
        'notes' => 'permit_empty|max_length[500]',
        'payment_gateway' => 'required|in_list[online_banking,credit_card,debit_card,cash]',
        'deposit_amount' => 'required|numeric|greater_than[0]',
        'payment_status' => 'required|in_list[pending,paid,refunded]',
        'total_amount' => 'permit_empty|numeric|greater_than[0]',
    ];
}