<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class FacilityModel extends Model
{
    protected $table         = 'facilities';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'name',
        'description',
        'category_id',
        'agency_id',
        'type',
        'status',
        'capacity',
        'location',
        'created_by',
    ];
    protected $useTimestamps = true;
    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'description' => 'permit_empty',
        'category_id' => 'required|integer',
        'agency_id' => 'permit_empty|integer',
        'type' => 'required|in_list[public,agency]',
        'status' => 'required|in_list[active,inactive]',
        'capacity' => 'permit_empty|integer',
        'location' => 'permit_empty|max_length[255]',
        'created_by' => 'required|integer',
    ];
}