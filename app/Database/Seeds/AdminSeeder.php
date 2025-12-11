<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'email' => 'admin@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'full_name' => 'Administrator',
            'phone' => '0123456789',
            'role' => 'admin',
            'user_type' => 'public',
            'approved' => 1,
            'status' => 'active',
        ];

        $this->db->table('users')->insert($data);
    }
}