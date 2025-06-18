<?php

namespace App\Application\UseCases;

use App\Domain\Payment\Enums\PaymentMethod;

class CalculateCartTotalUseCase
{
    /**
     * Executes the calculation of the payable amount based on the total, payment method, and installments.;
     *
     * @param int $total The total amount to be paid.
     * @param string $method The payment method used for the transaction.
     * @param int $installments The number of installments for the payment.
     * @return int The calculated payable amount after applying any discounts or interest based on the strategy.
     */
    public function execute(int $total, string $method, int $installments): int
    {

        $paymentMethod = PaymentMethod::from($method);
        $strategyClass = $paymentMethod->getStrategy();
        $strategy = new $strategyClass();

        return $strategy->getPayableAmount($total, $installments);
    }
}
