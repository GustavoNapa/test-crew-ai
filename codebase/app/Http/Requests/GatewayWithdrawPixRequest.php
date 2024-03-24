<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GatewayWithdrawPixRequest extends FormRequest
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
            'requestNumber' => 'required',
            'amount' => 'required',
            'key' => 'required',
            'key_type' => 'required|in:document,phoneNumber,email,randomKey,paymentCode',
            'client.name' => 'required', // DADOS DO CLIENTE SOLICITANTE
            'client.document' => 'required', // DADOS DO CLIENTE SOLICITANTE
            'client.email' => 'required',
            // DADOS DO CLIENTE SOLICITANTE
        ];
    }

    public function messages()
    {
        return [
            'requestNumber.required' => 'O numero da requisição é obrigatório',
            'amount.required' => 'O valor é obrigatório',
            'key.required' => 'A chave PIX é obrigatória',
            'key_type.required' => 'O tipo da chave PIX é obrigatória',
            'key_type.in' => 'O tipo da chave PIX é inválida',
            'client.name.required' => 'O campo nome do cliente é obrigatório.',
            'client.document.required' => 'O campo documento do cliente é obrigatório.',
            'client.email.required' => 'O campo e-mail do cliente é obrigatório.',
        ];
    }
}
