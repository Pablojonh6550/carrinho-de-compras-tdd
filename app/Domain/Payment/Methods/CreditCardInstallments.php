<?php

namespace App\Domain\Payment\Methods;

use App\Domain\Payment\Interfaces\PaymentMethodInterface;

class CreditCardInstallments implements PaymentMethodInterface
{
    public function getPayableAmount(int $total, ?int $installments): int
    {
        $taxInstallmentCard = config("constants.TAX_INSTALLMENT_CARD");

        return (int) round($total * pow(1 + $taxInstallmentCard, $installments));
    }
}
