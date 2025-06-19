<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Cart\CartService;
use Mockery;

class CartControllerTest extends TestCase
{
    public function test_finish_cart_returns_200_on_success_with_pix()
    {
        $payload = [
            'method' => 'PIX',
            'installments' => 1,
            'products' => [
                ['name' => 'Smartphone Galaxy A54', 'value' => 1799.9, 'quantity' => 1],
                ['name' => 'Notebook Lenovo IdeaPad 3', 'value' => 2699, 'quantity' => 1],
            ],
        ];

        $response = $this->postJson('/api/cart/finish', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => ['total_value']
            ]);
    }

    public function test_finish_cart_returns_200_on_success_with_credit_card_one_time()
    {
        $payload = [
            'method' => 'CREDIT_CARD_ONE_TIME',
            'installments' => 1,
            'products' => [
                ['name' => 'Smartphone Galaxy A54', 'value' => 1799.9, 'quantity' => 1],
                ['name' => 'Notebook Lenovo IdeaPad 3', 'value' => 2699, 'quantity' => 1],
            ],
        ];

        $response = $this->postJson('/api/cart/finish', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => ['total_value']
            ]);
    }

    public function test_finish_cart_returns_200_on_success_with_credit_card_installments()
    {
        $payload = [
            'method' => 'CREDIT_CARD_INSTALLMENTS',
            'installments' => 3,
            'products' => [
                ['name' => 'Smartphone Galaxy A54', 'value' => 1799.9, 'quantity' => 1],
                ['name' => 'Notebook Lenovo IdeaPad 3', 'value' => 2699, 'quantity' => 1],
            ],
        ];

        $response = $this->postJson('/api/cart/finish', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => ['total_value']
            ]);
    }

    public function test_finish_cart_returns_422_when_payload_is_invalid()
    {
        $payload = [
            'method' => '',
            'installments' => 0,
            'products' => [],
        ];

        $response = $this->postJson('/api/cart/finish', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['method', 'installments', 'products']);
    }

    public function test_finish_cart_returns_400_when_service_fails()
    {
        // Mock do CartService para forçar retorno false
        $mockService = Mockery::mock(CartService::class);
        $mockService->shouldReceive('finishCart')
            ->once()
            ->andReturn(false);

        // Injete o mock no container do Laravel
        $this->app->instance(CartService::class, $mockService);

        $payload = [
            'method' => 'PIX',
            'installments' => 1,
            'products' => [
                ['name' => 'Fake Product', 'value' => 1, 'quantity' => 1],
            ],
        ];

        $response = $this->postJson('/api/cart/finish', $payload);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'não foi possivel realizar o pagamento',
                'data' => false,  // seu controller retorna $result que será false
            ]);
    }
}
