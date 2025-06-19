<?php

namespace App\Services\Cart;

use App\Application\UseCases\CalculateCartTotalUseCase;

class CartService
{
    public function __construct(private CalculateCartTotalUseCase $cartUseCase) {}

    public function finishCart($products, $method, $installments): float
    {
        $total = $this->calculateCartTotal($products);

        $result = $this->cartUseCase->execute($total, $method, $installments);

        return $result;
    }

    public function calculateCartTotal(array $products): mixed
    {
        $total = collect($products)->sum(fn($product) => $product['value'] * $product['quantity']);
        return $total;
    }
}
