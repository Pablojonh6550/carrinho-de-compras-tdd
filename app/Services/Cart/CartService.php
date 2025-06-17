<?php

namespace App\Services\Cart;

use App\Application\UseCases\CalculateCartTotalUseCase;

class CartService
{
    public function __construct(private CalculateCartTotalUseCase $cartUseCase) {}

    public function finishCart($products, $method, $installments)
    {
        $result = $this->cartUseCase->execute($products, $method, $installments);
    }
}
