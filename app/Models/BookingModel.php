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
    ];
    protected $useTimestamps = true;
    protected $validationRules = [
        'user_id' => 'required|integer',
        'facility_id' => 'required|integer',
        'start_date' => 'required|valid_date',
        'end_date' => 'required|valid_date',
        'status' => 'required|in_list[pending,approved,cancelled]',
        'notes' => 'permit_empty|max_length[500]',
    ];
}