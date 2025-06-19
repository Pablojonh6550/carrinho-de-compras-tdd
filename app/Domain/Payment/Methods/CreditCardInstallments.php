<?php

namespace App\Domain\Payment\Methods;

use App\Domain\Payment\Interfaces\PaymentMethodInterface;

class CreditCardInstallments implements PaymentMethodInterface
{
    /**
     * @param int $total The total amount to be paid in cents.
     * @param int|null $installments The number of installments for the payment.
     * @return int The calculated payable amount after applying the interest based on the strategy.
     */
    public function getPayableAmount(float $total, ?int $installments): float
    {
        $taxInstallmentCard = config("constants.TAX_INSTALLMENT_CARD");

        $valueTotal = $total / 100;

        $montante = $valueTotal * pow(1 + $taxInstallmentCard, $installments);

        return (float) round($montante * 100, 2);
    }
}
