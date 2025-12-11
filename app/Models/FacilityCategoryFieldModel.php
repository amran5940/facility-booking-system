<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class FacilityCategoryFieldModel extends Model
{
    protected $table         = 'facility_category_fields';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'category_id',
        'field_name',
        'field_label',
        'field_type',
        'options',
        'required',
        'sort_order',
    ];
    protected $useTimestamps = true;
    protected $validationRules = [
        'category_id' => 'required|integer',
        'field_name' => 'required|max_length[100]|alpha_dash',
        'field_label' => 'required|max_length[255]',
        'field_type' => 'required|in_list[text,textarea,number,date,select,checkbox]',
        'options' => 'permit_empty',
        'required' => 'permit_empty|in_list[0,1]',
        'sort_order' => 'permit_empty|integer',
    ];
}