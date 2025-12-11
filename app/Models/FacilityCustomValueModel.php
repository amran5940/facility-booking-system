<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class FacilityCustomValueModel extends Model
{
    protected $table         = 'facility_custom_values';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'facility_id',
        'field_id',
        'field_value',
    ];
    protected $useTimestamps = true;
    protected $validationRules = [
        'facility_id' => 'required|integer',
        'field_id' => 'required|integer',
        'field_value' => 'permit_empty',
    ];
}