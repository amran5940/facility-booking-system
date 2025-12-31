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
        'latitude',
        'longitude',
        'pricing_type',
        'price_per_hour',
        'price_per_day',
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
        'latitude' => 'permit_empty|decimal',
        'longitude' => 'permit_empty|decimal',
        'pricing_type' => 'permit_empty|in_list[hourly,daily]',
        'price_per_hour' => 'permit_empty|decimal',
        'price_per_day' => 'permit_empty|decimal',
        'created_by' => 'required|integer',
    ];
}