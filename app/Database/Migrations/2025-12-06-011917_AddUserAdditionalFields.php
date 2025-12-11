<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserAdditionalFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'full_name',
            ],
            'date_of_birth' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'phone',
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'date_of_birth',
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['male', 'female', 'other'],
                'null' => true,
                'after' => 'address',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', [
            'phone',
            'date_of_birth',
            'address',
            'gender'
        ]);
    }
}
