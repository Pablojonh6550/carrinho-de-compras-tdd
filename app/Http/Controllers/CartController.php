<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\Cart\CartService;
use Exception;
use App\Http\Requests\PaymentRequest;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function finishCart(): JsonResponse
    {
        $cart = [
            'products' => [
                [
                    'id' => 1,
                    'name' => 'leite',
                    'value' => '1000',
                    'quantity' => 1
                ],
                [
                    'id' => 2,
                    'name' => 'arroz',
                    'value' => '2000',
                    'quantity' => 1
                ],
                [
                    'id' => 3,
                    'name' => 'feijao',
                    'value' => '3340',
                    'quantity' => 1
                ]
            ],
            'method_payment' => 'CREDIT_CARD_INSTALLMENTS',
            'installments' => 3
        ];
        try {

            $result = $this->cartService->finishCart($cart['products'], $cart['method_payment'], $cart['installments']);
            if ($result)
                return response()->json(['message' => 'Pagamento realizado com sucesso', 'data' => ['total_value' => $result]], 200);
            return response()->json(['message' => 'não foi possivel realizar o pagamento', 'data' => $result], 400);
        } catch (Exception $e) {
            Log::error('Erro ao tentar realizar pagamento', [
                'paymeny_method' => $cart['method_payment'],
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
