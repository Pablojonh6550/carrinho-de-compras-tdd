<?php

namespace Tests\Unit\Domain\Payment\Methods;

use App\Domain\Payment\Methods\PixPayment;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class PixPaymentTest extends TestCase
{
    /** @test */
    public function it_applies_10_percent_discount_correctly(): void
    {
        config()->set('constants.DISCOUNT_ONE_TIME', 0.9);

        $pix = new PixPayment();

        $result = $pix->getPayableAmount(11000);

        $total = 11000;
        $expected = (int) round($total * 0.9);

        $this->assertEquals($expected, $result);
    }
}
