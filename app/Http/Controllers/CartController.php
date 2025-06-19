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

    public function finishCart(PaymentRequest $request): JsonResponse
    {
        dd("aqui");
        try {

            $result = $this->cartService->finishCart($request->validated('products'), $request->validated('method'), $request->validated('installments'));
            if ($result)
                return response()->json(['message' => 'Pagamento realizado com sucesso', 'data' => ['total_value' => $result]], 200);
            return response()->json(['message' => 'não foi possivel realizar o pagamento', 'data' => $result], 400);
        } catch (Exception $e) {
            Log::error('Erro ao tentar realizar pagamento', [
                'paymeny_method' => $request->validated('method'),
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
