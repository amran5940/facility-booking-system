<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropUsernameFromUsers extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('users', 'username');
    }

    public function down()
    {
        $this->forge->addColumn('users', [
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'unique' => true,
            ],
        ]);
    }
}
