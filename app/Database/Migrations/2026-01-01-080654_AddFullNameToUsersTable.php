<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFullNameToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'full_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'after'      => 'password',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'full_name');
    }
}
