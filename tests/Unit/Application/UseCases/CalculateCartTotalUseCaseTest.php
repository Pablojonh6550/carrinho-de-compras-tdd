<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\UseCases\CalculateCartTotalUseCase;
use App\Domain\Payment\Enums\PaymentMethod;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class CalculateCartTotalUseCaseTest extends TestCase
{
    public function test_it_uses_pix_payment_and_applies_discount()
    {

        Config::set('constants.DISCOUNT_ONE_TIME', 0.9);
        $useCase = new CalculateCartTotalUseCase();

        $total = 10000;
        $installments = 1;
        $method = PaymentMethod::PIX->value;

        $result = $useCase->execute($total, $method, $installments);

        $this->assertEquals(9000, $result);
    }
}
