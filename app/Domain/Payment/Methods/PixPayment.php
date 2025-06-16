<?php

namespace App\Domain\Payment\Methods;

use App\Domain\Payment\Interfaces\PaymentMethodInterface;

class PixPayment implements PaymentMethodInterface
{
    public function getPayableAmount(int $total, ?int $installments = null): int
    {
        $discount = config("constants.DISCOUNT_ONE_TIME");
        return (int) round($total / $discount);
    }
}
