<?php

namespace App\Domain\Payment\Interfaces;

interface PaymentMethodInterface
{
    public function getPayableAmount(float $total, ?int $installments): float;
}
