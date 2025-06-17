<?php

namespace App\Application\UseCases;

use App\Domain\Payment\Enums\PaymentMethod;

class CalculateCartTotalUseCase
{
    public function execute(int $total, string $method, int $installments): float
    {

        $paymentMethod = PaymentMethod::from($method);
        $strategyClass = $paymentMethod->getStrategy();
        $strategy = new $strategyClass();

        return $strategy->calculate($total, $installments);
    }
}
