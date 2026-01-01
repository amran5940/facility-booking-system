<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCreatedByToFacilityCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('facility_categories', [
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'status',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('facility_categories', 'created_by');
    }
}
