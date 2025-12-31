<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'email',
        'password',
        'full_name',
        'phone',
        'date_of_birth',
        'address',
        'gender',
        'role',
        'agency_id',
        'user_type',
        'approved',
        'status',
        'agency_application_status',
        'requested_agency_id',
        'application_notes',
    ];
    protected $useTimestamps = true;
    protected $validationRules = [
        'email'    => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[8]',
        'full_name' => 'required',
        'phone' => 'permit_empty|regex_match[/^[0-9+\-\s()]+$/]|max_length[20]',
        'date_of_birth' => 'permit_empty|valid_date[Y-m-d]',
        'address' => 'permit_empty|max_length[500]',
        'gender' => 'permit_empty|in_list[male,female,other]',
        'role'     => 'required|in_list[admin,manager,user]',
        'agency_id' => 'permit_empty|integer',
        'user_type' => 'required|in_list[public,agency]',
        'approved'  => 'permit_empty|in_list[0,1]',
        'status'    => 'required|in_list[active,inactive]',
        'agency_application_status' => 'permit_empty|in_list[none,pending,approved,rejected]',
        'requested_agency_id' => 'permit_empty|integer',
        'application_notes' => 'permit_empty',
    ];

    protected $updateValidationRules = [
        'email'    => 'required|valid_email',
        'password' => 'permit_empty|min_length[8]',
        'full_name' => 'required',
        'phone' => 'permit_empty|regex_match[/^[0-9+\-\s()]+$/]|max_length[20]',
        'date_of_birth' => 'permit_empty|valid_date[Y-m-d]',
        'address' => 'permit_empty|max_length[500]',
        'gender' => 'permit_empty|in_list[male,female,other]',
        'role'     => 'required|in_list[admin,manager,user]',
        'agency_id' => 'permit_empty|integer',
        'user_type' => 'required|in_list[public,agency]',
        'approved'  => 'permit_empty|in_list[0,1]',
        'status'    => 'required|in_list[active,inactive]',
        'agency_application_status' => 'permit_empty|in_list[none,pending,approved,rejected]',
        'requested_agency_id' => 'permit_empty|integer',
        'application_notes' => 'permit_empty',
    ];
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = [];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        }
        return $data;
    }

    public function update($id = null, $data = null): bool
    {
        // Use update validation rules for updates
        $this->validationRules = $this->updateValidationRules;
        return parent::update($id, $data);
    }
}
