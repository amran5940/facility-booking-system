<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class FacilityCategoryModel extends Model
{
    /**
     * Default fields keyed by category name.
     */
    private array $defaultFields = [
        'Hall' => [
            ['field_name' => 'capacity', 'field_label' => 'Seating Capacity', 'field_type' => 'number', 'required' => true],
            ['field_name' => 'location', 'field_label' => 'Location', 'field_type' => 'text', 'required' => true],
            ['field_name' => 'equipment', 'field_label' => 'Available Equipment', 'field_type' => 'textarea', 'required' => false],
        ],
        'Hostel' => [
            ['field_name' => 'capacity', 'field_label' => 'Room Capacity', 'field_type' => 'number', 'required' => true],
            ['field_name' => 'location', 'field_label' => 'Location', 'field_type' => 'text', 'required' => true],
            ['field_name' => 'amenities', 'field_label' => 'Amenities', 'field_type' => 'textarea', 'required' => false],
            ['field_name' => 'room_type', 'field_label' => 'Room Type', 'field_type' => 'select', 'required' => false, 'options' => ['Single', 'Double', 'Dormitory']],
        ],
        'Court' => [
            ['field_name' => 'capacity', 'field_label' => 'Player Capacity', 'field_type' => 'number', 'required' => true],
            ['field_name' => 'location', 'field_label' => 'Location', 'field_type' => 'text', 'required' => true],
            ['field_name' => 'surface_type', 'field_label' => 'Surface Type', 'field_type' => 'select', 'required' => false, 'options' => ['Grass', 'Clay', 'Hard Court', 'Carpet']],
            ['field_name' => 'indoor_outdoor', 'field_label' => 'Indoor/Outdoor', 'field_type' => 'select', 'required' => false, 'options' => ['Indoor', 'Outdoor']],
        ],
        'Vehicle' => [
            ['field_name' => 'capacity', 'field_label' => 'Passenger Capacity', 'field_type' => 'number', 'required' => true],
            ['field_name' => 'location', 'field_label' => 'Current Location', 'field_type' => 'text', 'required' => true],
            ['field_name' => 'vehicle_type', 'field_label' => 'Vehicle Type', 'field_type' => 'select', 'required' => false, 'options' => ['Car', 'Van', 'Bus', 'Truck']],
            ['field_name' => 'license_plate', 'field_label' => 'License Plate', 'field_type' => 'text', 'required' => false],
            ['field_name' => 'fuel_type', 'field_label' => 'Fuel Type', 'field_type' => 'select', 'required' => false, 'options' => ['Petrol', 'Diesel', 'Electric', 'Hybrid']],
        ],
    ];
    protected $table         = 'facility_categories';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'name',
        'description',
        'created_by',
    ];
    protected $useTimestamps = true;
    protected $validationRules = [
        'name' => 'required|max_length[100]|is_unique[facility_categories.name,id,{id}]',
        'description' => 'permit_empty',
        'created_by' => 'required|integer',
    ];

    /**
     * Get default fields for a category
     */
    public function getDefaultFields(string $categoryName): array
    {
        return $this->defaultFields[$categoryName] ?? [];
    }

    /**
     * Get default fields for all categories.
     */
    public function getAllDefaultFields(): array
    {
        return $this->defaultFields;
    }
}