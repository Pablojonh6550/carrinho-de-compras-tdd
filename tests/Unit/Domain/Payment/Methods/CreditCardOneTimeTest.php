<?php

namespace Tests\Unit\Domain\Payment\Methods;

use App\Domain\Payment\Methods\CreditCardOneTime;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class CreditCardOneTimeTest extends TestCase
{
    public function test_it_applies_discount_correctly(): void
    {
        config()->set(key: 'constants.DISCOUNT_ONE_TIME', value: 1.1);

        $method = new CreditCardOneTime();

        $total = 10000;
        $expected = (int) round($total / 1.1);

        $this->assertEquals($expected, $method->getPayableAmount($total));
    }
}
