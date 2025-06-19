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
        $products = [
            ['name' => "Smart TV LG 50'' 4K", 'value' => 2499.99, 'quantity' => 1],
            ['name' => 'Fone de Ouvido Bluetooth JBL', 'value' => 349.9, 'quantity' => 1],
        ];

        $expectedTotal = 2849.89; // 2499.99 + 349.9
        $method = 'PIX';
        $installments = 1;
        $expectedFinalAmount = 2849.89 * 0.90; // 10% desconto

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
        $expectedTotal = 4500;
        $method = 'CREDIT_CARD_ONE_TIME';
        $installments = 1;
        $expectedFinalAmount = $expectedTotal * 0.90; // 10% de desconto

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

        $expectedTotal = 4500;
        $method = 'CREDIT_CARD_INSTALLMENTS';
        $installments = 3;
        $expectedFinalAmount = (int) floor($expectedTotal * pow(1.01, $installments));

        $useCase = Mockery::mock(CalculateCartTotalUseCase::class);
        $useCase->shouldReceive('execute')
            ->once()
            ->with($expectedTotal, $method, $installments)
            ->andReturn($expectedFinalAmount);

        $cartService = new CartService($useCase);

        $result = $cartService->finishCart($products, $method, $installments);

        $this->assertEquals($expectedFinalAmount, $result);
    }

    public function test_calculate_cart_total_returns_correct_sum(): void
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
