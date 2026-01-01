<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFacilityCategoryFieldsTable extends Migration
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
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'field_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'field_label' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'field_type' => [
                'type'       => 'ENUM',
                'constraint' => ['text', 'textarea', 'number', 'date', 'select', 'checkbox'],
            ],
            'options' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'required' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
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
        $this->forge->createTable('facility_category_fields');
    }

    public function down()
    {
        $this->forge->dropTable('facility_category_fields');
    }
}
