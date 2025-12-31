<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class FacilityImageModel extends Model
{
    protected $table         = 'facility_images';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'facility_id',
        'image_data',
        'image_type',
        'is_primary',
        'sort_order',
    ];
    protected $useTimestamps = true;
    protected $validationRules = [
        'facility_id' => 'required|integer',
        'image_data' => 'required|max_length[255]',
        'image_type' => 'required|max_length[50]',
        'is_primary' => 'permit_empty|in_list[0,1]',
        'sort_order' => 'permit_empty|integer',
    ];

    /**
     * Get all images for a facility
     */
    public function getByFacility(int $facilityId): array
    {
        return $this->where('facility_id', $facilityId)
                    ->orderBy('is_primary', 'DESC')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Get primary image for a facility
     */
    public function getPrimaryImage(int $facilityId): ?array
    {
        return $this->where('facility_id', $facilityId)
                    ->where('is_primary', 1)
                    ->first();
    }

    /**
     * Set an image as primary and unset others
     */
    public function setPrimary(int $imageId, int $facilityId): bool
    {
        // Unset all primary flags for this facility
        $this->where('facility_id', $facilityId)
             ->set(['is_primary' => 0])
             ->update();
        
        // Set the specified image as primary
        return $this->update($imageId, ['is_primary' => 1]);
    }

    /**
     * Count images for a facility
     */
    public function countByFacility(int $facilityId): int
    {
        return $this->where('facility_id', $facilityId)->countAllResults();
    }
}
