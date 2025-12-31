<?php

namespace App\Controllers;

class ImageController extends BaseController
{
    /**
     * Serve facility image from filesystem
     */
    public function facilityImage(int $id)
    {
        $imageModel = new \App\Models\FacilityImageModel();
        $image = $imageModel->find($id);
        
        if (!$image) {
            return $this->response->setStatusCode(404, 'Image not found');
        }
        
        // image_data now contains the file path
        $filePath = FCPATH . 'uploads/facilities/' . $image['image_data'];
        
        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404, 'File not found');
        }
        
        return $this->response
            ->setHeader('Content-Type', $image['image_type'])
            ->setHeader('Cache-Control', 'max-age=86400')
            ->setBody(file_get_contents($filePath));
    }
}
