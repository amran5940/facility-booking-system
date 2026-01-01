<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsActiveToPaymentGatewaysTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('payment_gateways', [
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'after'      => 'config',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('payment_gateways', 'is_active');
    }
}
