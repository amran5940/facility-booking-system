<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCoordinatesToFacilities extends Migration
{
    public function up()
    {
        $fields = [
            'latitude' => [
                'type' => 'DECIMAL',
                'constraint' => '10,6',
                'null' => true,
            ],
            'longitude' => [
                'type' => 'DECIMAL',
                'constraint' => '10,6',
                'null' => true,
            ],
        ];

        $this->forge->addColumn('facilities', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('facilities', ['latitude', 'longitude']);
    }
}
