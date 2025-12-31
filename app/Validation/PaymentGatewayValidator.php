<?php

namespace App\Validation;

class PaymentGatewayValidator
{
    public static function validate($value, string &$error = null): bool
    {
        $paymentGatewayModel = new \App\Models\PaymentGatewayModel();
        $gateway = $paymentGatewayModel->where('code', $value)->where('is_active', 1)->first();

        if (!$gateway) {
            $error = 'Kaedah pembayaran tidak sah atau tidak aktif.';
            return false;
        }

        return true;
    }
}