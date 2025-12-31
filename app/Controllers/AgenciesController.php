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
            'status'      => $this->request->getPost('status') ?? 'active',
        ];

        $agencyModel = new AgencyModel();
        if ($agencyModel->insert($data)) {
            return redirect()->to('/admin/agencies')->with('success', 'Agensi berjaya dicipta');
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
        $defaultFieldSets = array_keys($categoryModel->getAllDefaultFields());

        return view('facility_categories/index', [
            'facility_categories' => $categories,
            'default_field_sets' => $defaultFieldSets,
        ]);
    }

    public function createFacilityCategory()
    {
        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'description' => trim((string) $this->request->getPost('description')),
            'created_by' => session('user')['id'],
        ];

        $facilityCategoryModel = new \App\Models\FacilityCategoryModel();
        $fieldModel = new \App\Models\FacilityCategoryFieldModel();
        $selectedDefaultSet = (string) $this->request->getPost('default_field_set');

        $categoryId = $facilityCategoryModel->insert($data);
        if ($categoryId === false) {
            return redirect()->back()->withInput()->with('errors', $facilityCategoryModel->errors());
        }

        // If a default field set was chosen, seed those fields into the new category.
        if ($selectedDefaultSet !== '') {
            $defaultFields = $facilityCategoryModel->getDefaultFields($selectedDefaultSet);
            foreach ($defaultFields as $index => $field) {
                $fieldModel->insert([
                    'category_id' => (int) $categoryId,
                    'field_name' => $field['field_name'],
                    'field_label' => $field['field_label'],
                    'field_type' => $field['field_type'],
                    'options' => isset($field['options']) ? json_encode($field['options']) : null,
                    'required' => $field['required'] ? 1 : 0,
                    'sort_order' => $index * 10,
                ]);
            }
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
        $allDefaultFields = $facilityCategoryModel->getAllDefaultFields();
        
        return view('facility_categories/fields', [
            'category' => $category, 
            'customFields' => $customFields,
            'defaultFields' => $defaultFields,
            'allDefaultFields' => $allDefaultFields,
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

    public function editManager($id)
    {
        $userModel = new UserModel();
        $agencyModel = new AgencyModel();
        
        $manager = $userModel->find($id);
        
        if (!$manager || $manager['role'] !== 'manager') {
            return redirect()->to('/admin/managers')->with('error', 'Manager not found');
        }
        
        $agencies = $agencyModel->findAll();
        
        return view('managers/edit', [
            'manager' => $manager,
            'agencies' => $agencies
        ]);
    }

    public function updateManager($id)
    {
        $userModel = new UserModel();
        
        $manager = $userModel->find($id);
        if (!$manager || $manager['role'] !== 'manager') {
            return redirect()->to('/admin/managers')->with('error', 'Manager not found');
        }
        
        $agencyId = (int) $this->request->getPost('agency_id');
        $phone = trim((string) $this->request->getPost('phone'));
        $newEmail = strtolower(trim($this->request->getPost('email')));
        $currentEmail = strtolower(trim($manager['email']));
        
        $data = [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email' => $newEmail,
            'phone' => $phone, // Always include phone, even if empty
            'agency_id' => $agencyId > 0 ? $agencyId : null,
            'status' => $this->request->getPost('status'),
            'role' => 'manager', // Ensure role remains manager
            'user_type' => 'agency', // Ensure user_type remains agency for managers
        ];
        
        // Check if email is unique (excluding current user)
        $existingUser = $userModel->where('email', $newEmail)->whereNotIn('id', [$id])->first();
        if ($existingUser) {
            return redirect()->back()->withInput()->with('error', 'Email already exists');
        }
        
        if ($userModel->update($id, $data) === false) {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }
        
        return redirect()->to('/admin/managers')->with('success', 'Manager updated successfully');
    }

    public function deleteManager($id)
    {
        $userModel = new UserModel();
        
        $manager = $userModel->find($id);
        if (!$manager || $manager['role'] !== 'manager') {
            return redirect()->to('/admin/managers')->with('error', 'Manager not found');
        }
        
        // Check if manager is assigned to an agency
        if ($manager['agency_id']) {
            return redirect()->to('/admin/managers')->with('error', 'Cannot delete manager who is assigned to an agency. Please unassign the manager from the agency first.');
        }
        
        if ($userModel->delete($id) === false) {
            return redirect()->to('/admin/managers')->with('error', 'Failed to delete manager');
        }
        
        return redirect()->to('/admin/managers')->with('success', 'Manager deleted successfully');
    }
}