<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\Cart\CartService;
use Illuminate\Support\Facades\Route;
use Mockery;

class CartControllerTest extends TestCase
{
    public function test_finish_cart_returns_success_response()
    {
        $fakeTotal = 6700;

        $cartService = Mockery::mock(CartService::class);
        $cartService->shouldReceive('finishCart')
            ->once()
            ->withArgs(function ($products, $method, $installments) {
                return $method === 'CREDIT_CARD_INSTALLMENTS' && $installments === 3;
            })
            ->andReturn($fakeTotal);

        $this->app->instance(CartService::class, $cartService);

        Route::get('/cart/finish', [\App\Http\Controllers\CartController::class, 'finishCart']);

        $response = $this->getJson('/cart/finish');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Pagamento realizado com sucesso',
                'data' => ['total_value' => $fakeTotal],
            ]);
    }

    public function test_finish_cart_returns_400_when_service_returns_false()
    {

        $cartService = Mockery::mock(CartService::class);
        $cartService->shouldReceive('finishCart')
            ->once()
            ->andReturn(false);

        $this->app->instance(CartService::class, $cartService);

        Route::get('/cart/finish', [\App\Http\Controllers\CartController::class, 'finishCart']);

        $response = $this->getJson('/cart/finish');

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'não foi possivel realizar o pagamento',
            ]);
    }

    public function test_finish_cart_returns_500_on_exception()
    {

        $cartService = Mockery::mock(CartService::class);
        $cartService->shouldReceive('finishCart')
            ->once()
            ->andThrow(new \Exception('Erro interno no serviço'));

        $this->app->instance(CartService::class, $cartService);

        Route::get('/cart/finish', [\App\Http\Controllers\CartController::class, 'finishCart']);

        $response = $this->getJson('/cart/finish');

        $response->assertStatus(500)
            ->assertJson([
                'message' => 'Erro interno no serviço',
            ]);
    }
}
