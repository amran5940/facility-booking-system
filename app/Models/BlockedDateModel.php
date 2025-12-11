<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class BlockedDateModel extends Model
{
    protected $table            = 'blocked_dates';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['facility_id', 'blocked_date', 'reason', 'created_by'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'facility_id'  => 'required|integer',
        'blocked_date' => 'required|valid_date',
        'created_by'   => 'required|integer',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}
