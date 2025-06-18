<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\Cart\CartService;
use App\Application\UseCases\CalculateCartTotalUseCase;
use Mockery;

class CartServiceTest extends TestCase
{
    public function test_finish_cart_calculates_total_and_applies_payment_logic_with_pix(): void
    {
        // Arrange
        $products = [
            ['name' => 'leite', 'value' => 1000, 'quantity' => 2],
            ['name' => 'arroz', 'value' => 2500, 'quantity' => 1],
        ];
        $expectedTotal = 2000 + 2500;
        $method = 'PIX';
        $installments = 1;
        $expectedFinalAmount = 4050;

        $useCase = Mockery::mock(CalculateCartTotalUseCase::class);
        $useCase->shouldReceive('execute')
            ->once()
            ->with($expectedTotal, $method, $installments)
            ->andReturn($expectedFinalAmount);

        $cartService = new CartService($useCase);

        $result = $cartService->finishCart($products, $method, $installments);

        $this->assertEquals($expectedFinalAmount, $result);
    }

    public function test_finish_cart_calculates_total_and_applies_payment_logic_with_credit_card_one_time(): void
    {

        $products = [
            ['name' => 'leite', 'value' => 1000, 'quantity' => 2],
            ['name' => 'arroz', 'value' => 2500, 'quantity' => 1],
        ];
        $expectedTotal = 2000 + 2500;
        $method = 'CREDIT_CARD_ONE_TIME';
        $installments = 1;
        $expectedFinalAmount = 4050;

        $useCase = Mockery::mock(CalculateCartTotalUseCase::class);
        $useCase->shouldReceive('execute')
            ->once()
            ->with($expectedTotal, $method, $installments)
            ->andReturn($expectedFinalAmount);

        $cartService = new CartService($useCase);

        $result = $cartService->finishCart($products, $method, $installments);

        $this->assertEquals($expectedFinalAmount, $result);
    }

    public function test_finish_cart_calculates_total_and_applies_payment_logic_with_credit_card_installments(): void
    {
        $products = [
            ['name' => 'leite', 'value' => 1000, 'quantity' => 2],
            ['name' => 'arroz', 'value' => 2500, 'quantity' => 1],
        ];

        $expectedTotal = 2000 + 2500;
        $method = 'CREDIT_CARD_INSTALLMENTS';
        $installments = 3;

        $expectedFinalAmount = (int) floor((4500 / 100) * pow(1 + 0.01, $installments) * 100);

        $useCase = Mockery::mock(CalculateCartTotalUseCase::class);
        $useCase->shouldReceive('execute')
            ->once()
            ->with($expectedTotal, $method, $installments)
            ->andReturn($expectedFinalAmount);

        $cartService = new CartService($useCase);

        $result = $cartService->finishCart($products, $method, $installments);

        $this->assertEquals($expectedFinalAmount, $result);
    }


    public function test_calculate_cart_total_returns_correct_sum()
    {

        $cartService = new CartService(Mockery::mock(CalculateCartTotalUseCase::class));
        $products = [
            ['name' => 'leite', 'value' => 1200, 'quantity' => 1],
            ['name' => 'arroz', 'value' => 800, 'quantity' => 3],
        ];

        $total = $cartService->calculateCartTotal($products);

        $this->assertEquals(3600, $total);
    }
}
