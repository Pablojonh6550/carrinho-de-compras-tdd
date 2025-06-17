<?php

namespace Tests\Unit\Domain\Payment\Methods;

use App\Domain\Payment\Methods\CreditCardInstallments;
use Tests\TestCase;

class CreditCardInstallmentsTest extends TestCase
{
    public function test_calculate_total_with_installments_interest(): void
    {
        $method = new CreditCardInstallments();

        config()->set('constants.TAX_INSTALLMENT_CARD', 0.01);
        $total = 100000;
        $installments = 3;

        $result = $method->getPayableAmount($total, $installments);

        $this->assertEquals(103030, $result);
    }

    /**
     * @dataProvider installmentProvider
     */
    public function test_interest_applies_correctly_for_installments(int $installments, int $expected): void
    {
        $total = 10000;

        config()->set('constants.TAX_INSTALLMENT_CARD', 0.01);

        $paymentMethod = new CreditCardInstallments();
        $result = $paymentMethod->getPayableAmount($total, $installments);

        $this->assertEquals($expected, $result, "Falha no cálculo de juros para $installments parcelas.");
    }

    public static function installmentProvider(): array
    {
        $base = 10000;
        $rate = 0.01;
        $cases = [];

        for ($n = 2; $n <= 12; $n++) {
            $montante = (int) round($base * pow(1 + $rate, $n));
            $cases[] = [$n, $montante];
        }

        return $cases;
    }
}
