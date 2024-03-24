<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DynamicQrCodeRequest extends FormRequest
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
        // CAMPOS OBRIGATÓRIOS
        // requestNumber => Numero do pedido
        // dueDate => Data de Vencimento
        // amount => Valor da Cobrança
        // name => nome
        // document => CPF
        // email => email
        
        return [
            'requestNumber' => 'required|string|max:255',
            'dueDate' => 'required|date',
            'amount' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'shippingAmount' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'discountAmount' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'usernameCheckout' => 'nullable|string|max:255',
            'callbackUrl' => 'nullable|url|max:255',

            'client.name' => 'required|string|max:255',
            'client.document' => 'required|string|max:20',
            'client.email' => 'required|email|max:255',
            'client.phoneNumber' => 'nullable|string|max:20',

            'client.address.codIbge' => 'nullable|string|max:255',
            'client.address.street' => 'nullable|string|max:255',
            'client.address.number' => 'nullable|string|max:10',
            'client.address.complement' => 'nullable|string|max:255',
            'client.address.zipCode' => 'nullable|string|max:10',
            'client.address.neighborhood' => 'nullable|string|max:255',
            'client.address.city' => 'nullable|string|max:255',
            'client.address.state' => 'nullable|string|max:255',

            'products.*.description' => 'nullable|string|max:255',
            'products.*.quantity' => 'nullable|numeric|digits_between:1,9',
            'products.*.value' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',

            'split.username' => 'nullable|string|max:255',
            'split.percentageSplit' => 'nullable|numeric|digits_between:1,9',
        ];
    }

    public function messages()
    {
        return [
            'dueDate.max' => 'O campo data de vencimento não é uma data válida.',
            'regex' => 'O campo :attribute é inválido.'
        ];
    }

    public function attributes()
    {
        return [
            'requestNumber' => 'número da requisição',
            'dueDate' => 'data de vencimento',
            'amount' => 'valor',
            'shippingAmount' => 'taxa de entrega',
            'discountAmount' => 'valor do desconto',
            'usernameCheckout' => 'nome de usuário',
            'callbackUrl' => 'URL de retorno',


            'client.name' => 'nome do cliente',
            'client.document' => 'documento do cliente',
            'client.email' => 'e-mail do cliente',
            'client.phoneNumber' => 'telefone do cliente',

            'client.address.codIbge' => 'código do IBGE',
            'client.address.street' => 'endereço',
            'client.address.number' => 'número',
            'client.address.complement' => 'complemento',
            'client.address.zipCode' => 'CEP',
            'client.address.neighborhood' => 'bairro',
            'client.address.city' => 'cidade',
            'client.address.state' => 'estado',

            'products.*.description' => 'descrição',
            'products.*.quantity' => 'quantidade',
            'products.*.value' => 'valor',

            'split.username' => 'nome de usuário',
            'split.percentageSplit' => 'porcentagem',
        ];
    }
}
