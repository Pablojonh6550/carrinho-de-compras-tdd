<?php

namespace App\Domain\Payment\Methods;

use App\Domain\Payment\Interfaces\PaymentMethodInterface;

class CreditCardOneTime implements PaymentMethodInterface
{
    /**
     * Calculates the payable amount after applying a one-time discount.
     *
     * @param int $total The total amount to be paid.
     * @param int|null $installments The number of installments for the payment. Defaults to 1.
     * @return int The calculated payable amount after applying the discount.
     */
    public function getPayableAmount(float $total, ?int $installments = 1): float
    {
        $discount = config("constants.DISCOUNT_ONE_TIME");
        return (float) round($total * $discount, 2);
    }
}
