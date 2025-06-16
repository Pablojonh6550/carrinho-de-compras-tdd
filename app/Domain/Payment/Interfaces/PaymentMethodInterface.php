<?php

namespace App\Domain\Payment\Interfaces;

interface PaymentMethodInterface
{
    public function getPayableAmount(int $total, ?int $installments): int;
}
