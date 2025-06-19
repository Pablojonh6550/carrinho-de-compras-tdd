<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

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
            'products.*.name' => 'required|string',
            'products.*.value' => 'required|numeric|min:1',
            'products.*.quantity' => 'required|integer|min:1',
            'method' => 'required|string|in:PIX,CREDIT_CARD_ONE_TIME,CREDIT_CARD_INSTALLMENTS',
            'installments' => 'required|integer|min:1|max:12',
        ];
    }

    public function messages(): array
    {
        return [
            'products.required' => 'O campo produtos é obrigatório.',
            'products.*.name.required' => 'O campo nome do produto é obrigatório.',
            'products.*.value.required' => 'O campo valor do produto é obrigatório.',
            'products.*.quantity.required' => 'O campo quantidade do produto é obrigatório.',
            'method.required' => 'O campo método de pagamento é obrigatório.',
            'installments.required' => 'O campo parcelas é obrigatório.',
        ];
    }

    protected function failedValidation(Validator $validator): never
    {

        $errors = $validator->errors()->messages();

        $response = response()->json([
            'errors' => $errors,
        ], 422);

        throw new ValidationException($validator, $response);
    }
}
