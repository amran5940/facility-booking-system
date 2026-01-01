<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'date_of_birth' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'gender' => [
                'type'       => 'ENUM',
                'constraint' => ['male', 'female', 'other'],
                'null'       => true,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'date_of_birth' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'gender' => [
                'type'       => 'ENUM',
                'constraint' => ['male', 'female', 'other'],
                'null'       => true,
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'manager', 'user'],
            ],
            'agency_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'user_type' => [
                'type'       => 'ENUM',
                'constraint' => ['public', 'agency'],
            ],
            'approved' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
            ],
            'agency_application_status' => [
                'type'       => 'ENUM',
                'constraint' => ['none', 'pending', 'approved', 'rejected'],
                'null'       => true,
                'default'    => 'none',
            ],
            'requested_agency_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'application_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'agency_application_status' => [
                'type'       => 'ENUM',
                'constraint' => ['none', 'pending', 'approved', 'rejected'],
                'null'       => true,
                'default'    => 'none',
            ],
            'requested_agency_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'application_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
