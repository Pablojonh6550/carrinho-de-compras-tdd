<?php

namespace Tests\Feature;

use Tests\TestCase;

class HttpConnectionTest extends TestCase
{
    public function test_cart_finish_route_returns_successful_response(): void
    {
        $response = $this->get('api/cart/finish');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => ['total_value'],
            ]);
    }
}
