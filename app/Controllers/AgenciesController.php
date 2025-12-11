<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\AgencyModel;
use App\Models\UserModel;
use App\Models\FacilityModel;

class AgenciesController extends BaseController
{
    public function index()
    {
        $agencyModel = new AgencyModel();
        $userModel = new UserModel();

        $agencies = $agencyModel->findAll();
        $managers = $userModel->where('role', 'manager')->findAll();

        return view('agencies/index', [
            'agencies' => $agencies,
            'managers' => $managers,
        ]);
    }

    public function create()
    {
        $data = [
            'name'        => trim((string) $this->request->getPost('name')),
            'description' => trim((string) $this->request->getPost('description')),
            'status'      => 'active',
        ];

        $agencyModel = new AgencyModel();
        if ($agencyModel->insert($data)) {
            return redirect()->to('/admin/agencies')->with('success', 'Agency created');
        }

        return redirect()->back()->withInput()->with('errors', $agencyModel->errors());
    }

    public function createForm()
    {
        return view('agencies/create');
    }

    public function assignManager($agencyId)
    {
        $managerId = (int) $this->request->getPost('manager_id');

        if ($managerId <= 0) {
            return redirect()->to('/admin/agencies')->with('error', 'Please select a valid manager');
        }

        $userModel = new UserModel();
        $manager = $userModel->find($managerId);

        if (!$manager || $manager['role'] !== 'manager') {
            return redirect()->to('/admin/agencies')->with('error', 'Invalid manager selected');
        }

        // Check if manager is already assigned to another agency
        if ($manager['agency_id'] && $manager['agency_id'] != $agencyId) {
            return redirect()->to('/admin/agencies')->with('error', 'Manager is already assigned to another agency');
        }

        $userModel->update($managerId, ['agency_id' => $agencyId]);

        return redirect()->to('/admin/agencies')->with('success', 'Manager assigned successfully');
    }

    public function unassignManager($agencyId)
    {
        $userModel = new UserModel();
        // Find the manager assigned to this agency
        $manager = $userModel->where('agency_id', $agencyId)->where('role', 'manager')->first();

        if ($manager) {
            $userModel->update($manager['id'], ['agency_id' => null]);
            return redirect()->to('/admin/agencies')->with('success', 'Manager unassigned successfully');
        }

        return redirect()->to('/admin/agencies')->with('error', 'No manager assigned to this agency');
    }

    public function edit($id)
    {
        $agencyModel = new AgencyModel();
        $agency = $agencyModel->find($id);

        if (!$agency) {
            return redirect()->to('/admin/agencies')->with('error', 'Agency not found');
        }

        return view('agencies/edit', ['agency' => $agency]);
    }

    public function update($id)
    {
        $data = [
            'name'        => trim((string) $this->request->getPost('name')),
            'description' => trim((string) $this->request->getPost('description')),
            'status'      => $this->request->getPost('status'),
        ];

        $agencyModel = new AgencyModel();
        // For update, remove unique check on code to allow same code
        $agencyModel->setValidationRules([
            'name' => 'required|max_length[255]',
            'description' => 'permit_empty',
            'status' => 'required|in_list[active,inactive]',
        ]);

        if ($agencyModel->update($id, $data)) {
            return redirect()->to('/admin/agencies')->with('success', 'Agency updated');
        }

        return redirect()->back()->withInput()->with('errors', $agencyModel->errors());
    }

    public function delete($id)
    {
        $agencyModel = new AgencyModel();
        $userModel = new UserModel();
        $facilityModel = new FacilityModel();

        // Check if agency has users or facilities
        $hasUsers = $userModel->where('agency_id', $id)->countAllResults() > 0;
        $hasFacilities = $facilityModel->where('agency_id', $id)->countAllResults() > 0;

        if ($hasUsers || $hasFacilities) {
            return redirect()->to('/admin/agencies')->with('error', 'Cannot delete agency with associated users or facilities');
        }

        if ($agencyModel->delete($id)) {
            return redirect()->to('/admin/agencies')->with('success', 'Agency deleted');
        }

        return redirect()->to('/admin/agencies')->with('error', 'Failed to delete agency');
    }

    public function createManager()
    {
        $agencyId = (int) $this->request->getPost('agency_id');

        $data = [
            'email'      => trim((string) $this->request->getPost('email')),
            'password'   => (string) $this->request->getPost('password'),
            'full_name'  => trim((string) $this->request->getPost('full_name')),
            'role'       => 'manager',
            'agency_id'  => $agencyId > 0 ? $agencyId : null,
            'user_type'  => 'agency',
            'approved'   => 1,
            'status'     => 'active',
        ];

        $userModel = new UserModel();
        if ($userModel->insert($data) === false) {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }

        return redirect()->to('/admin/agencies')->with('success', 'Manager created and assigned successfully');
    }

    public function listManagers()
    {
        $userModel = new UserModel();
        $managers = $userModel->where('role', 'manager')->findAll();

        return view('managers/index', ['managers' => $managers]);
    }

    public function listFacilityCategories()
    {
        $categoryModel = new \App\Models\FacilityCategoryModel();
        $categories = $categoryModel->findAll();

        return view('facility_categories/index', ['facility_categories' => $categories]);
    }

    public function createFacilityCategory()
    {
        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'description' => trim((string) $this->request->getPost('description')),
            'created_by' => session('user')['id'],
        ];

        $facilityCategoryModel = new \App\Models\FacilityCategoryModel();
        if ($facilityCategoryModel->insert($data) === false) {
            return redirect()->back()->withInput()->with('errors', $facilityCategoryModel->errors());
        }

        return redirect()->back()->with('success', 'Facility category created successfully');
    }

    public function editFacilityCategory($id)
    {
        $facilityCategoryModel = new \App\Models\FacilityCategoryModel();
        $category = $facilityCategoryModel->find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'Facility category not found');
        }
        return view('facility_categories/edit', ['category' => $category]);
    }

    public function updateFacilityCategory($id)
    {
        $facilityCategoryModel = new \App\Models\FacilityCategoryModel();
        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'description' => trim((string) $this->request->getPost('description')),
        ];
        if ($facilityCategoryModel->update($id, $data) === false) {
            return redirect()->back()->withInput()->with('errors', $facilityCategoryModel->errors());
        }
        return redirect()->to('/admin')->with('success', 'Facility category updated successfully');
    }

    public function deleteFacilityCategory($id)
    {
        $facilityCategoryModel = new \App\Models\FacilityCategoryModel();
        $facilityModel = new \App\Models\FacilityModel();
        
        // Check if category is used by any facilities
        if ($facilityModel->where('category_id', $id)->countAllResults() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category that is assigned to facilities');
        }
        
        if ($facilityCategoryModel->delete($id) === false) {
            return redirect()->back()->with('error', 'Failed to delete facility category');
        }
        return redirect()->back()->with('success', 'Facility category deleted successfully');
    }

    public function manageCategoryFields($categoryId)
    {
        $facilityCategoryModel = new \App\Models\FacilityCategoryModel();
        $fieldModel = new \App\Models\FacilityCategoryFieldModel();
        
        $category = $facilityCategoryModel->find($categoryId);
        if (!$category) {
            return redirect()->back()->with('error', 'Facility category not found');
        }
        
        $customFields = $fieldModel->where('category_id', $categoryId)->orderBy('sort_order')->findAll();
        $defaultFields = $facilityCategoryModel->getDefaultFields($category['name']);
        
        return view('facility_categories/fields', [
            'category' => $category, 
            'customFields' => $customFields,
            'defaultFields' => $defaultFields
        ]);
    }

    public function addCategoryField($categoryId)
    {
        $facilityCategoryModel = new \App\Models\FacilityCategoryModel();
        $fieldModel = new \App\Models\FacilityCategoryFieldModel();
        
        $category = $facilityCategoryModel->find($categoryId);
        if (!$category) {
            return redirect()->back()->with('error', 'Facility category not found');
        }
        
        $data = [
            'category_id' => $categoryId,
            'field_name' => trim((string) $this->request->getPost('field_name')),
            'field_label' => trim((string) $this->request->getPost('field_label')),
            'field_type' => (string) $this->request->getPost('field_type'),
            'options' => $this->request->getPost('options') ? json_encode($this->request->getPost('options')) : null,
            'required' => $this->request->getPost('required') ? 1 : 0,
            'sort_order' => (int) $this->request->getPost('sort_order'),
        ];
        
        if ($fieldModel->insert($data) === false) {
            return redirect()->back()->withInput()->with('errors', $fieldModel->errors());
        }
        
        return redirect()->back()->with('success', 'Field added successfully');
    }

    public function deleteCategoryField($fieldId)
    {
        $fieldModel = new \App\Models\FacilityCategoryFieldModel();
        
        if ($fieldModel->delete($fieldId) === false) {
            return redirect()->back()->with('error', 'Failed to delete field');
        }
        
        return redirect()->back()->with('success', 'Field deleted successfully');
    }
}