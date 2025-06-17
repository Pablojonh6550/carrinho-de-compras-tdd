<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\Cart\CartService;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function finishCart(): JsonResponse
    {
        $cart = [
            'items' => [],
            'method_payment' => 0,
            'installments' => 0
        ];

        $this->cartService->finishCart($cart['items'], $cart['method_payment'], $cart['installments']);

        return response()->json(['success' => true]);
    }
}
