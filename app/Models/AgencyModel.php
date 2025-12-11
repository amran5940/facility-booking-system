<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class AgencyModel extends Model
{
    protected $table         = 'agencies';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'name',
        'description',
        'status',
    ];
    protected $useTimestamps = true;
    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'description' => 'permit_empty',
        'status' => 'required|in_list[active,inactive]',
    ];
}