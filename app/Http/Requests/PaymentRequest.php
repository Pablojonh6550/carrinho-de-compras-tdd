<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'products' => 'required|array|min:1',
            'produtos.*.name' => 'required|string',
            'produtos.*.value' => 'required|numeric|min:1',
            'produtos.*.quantity' => 'required|integer|min:1',
            'method' => 'required|string|in:PIX,CARTAO_CREDITO,CARTAO_CREDITO_PARCELADO',
            'installments' => 'required|integer|min:1|max:12',
        ];
    }

    public function messages(): array
    {
        return [
            'products.required' => 'O campo produtos é obrigatório.',
            'produtos.*.name.required' => 'O campo nome do produto é obrigatório.',
            'produtos.*.value.required' => 'O campo valor do produto é obrigatório.',
            'produtos.*.quantity.required' => 'O campo quantidade do produto é obrigatório.',
            'method.required' => 'O campo método de pagamento é obrigatório.',
            'installments.required' => 'O campo parcelas é obrigatório.',
        ];
    }
}
