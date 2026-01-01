<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAgencyApplicationFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'agency_application_status' => [
                'type' => 'ENUM',
                'constraint' => ['none', 'pending', 'approved', 'rejected'],
                'default' => 'none',
                'after' => 'approved',
            ],
            'requested_agency_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
                'after' => 'agency_application_status',
            ],
            'application_notes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'requested_agency_id',
            ],
        ]);

        // Add foreign key constraint for requested_agency_id
        $this->forge->addForeignKey('requested_agency_id', 'agencies', 'id', 'SET NULL', 'SET NULL');
    }

    public function down()
    {
        // Drop foreign key constraint first
        $this->forge->dropForeignKey('users', 'users_requested_agency_id_foreign');
        
        $this->forge->dropColumn('users', ['agency_application_status', 'requested_agency_id', 'application_notes']);
    }
}
