<?php

namespace Tests\Unit\Domain\Payment\Methods;

use App\Domain\Payment\Methods\CreditCardOneTime;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class CreditCardOneTimeTest extends TestCase
{
    public function test_it_applies_discount_correctly(): void
    {
        config()->set('constants.DISCOUNT_ONE_TIME', 0.9);

        $method = new CreditCardOneTime();

        $total = 10000;
        $expected = (int) round($total * 0.9);

        $this->assertEquals($expected, $method->getPayableAmount($total));
    }
}
