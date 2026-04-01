<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreRepasseRequest extends FormRequest
{
    /**
     * Determina se o usuário tem permissão para fazer essa requisição.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * As regras de ouro da validação.
     */
    public function rules(): array
    {
        return [
            'vendedora_id' => [
                'required',
                'integer',
                Rule::exists('vendedoras', 'id')->where(function ($query) {
                    $query->where('user_id', Auth::id());
                }),
            ],
            'roupa_id' => [
                'required',
                'integer',
                Rule::exists('roupas', 'id')->where(function ($query) {
                    $query->where('user_id', Auth::id());
                }),
            ],
            'quantidade_enviada' => ['required', 'integer', 'min:1'],
            'data_repasse' => ['required', 'date'],
        ];
    }

    /**
     * Mensagens amigáveis para o frontend.
     */
    public function messages(): array
    {
        return [
            'vendedora_id.exists' => 'A vendedora selecionada não existe no sistema.',
            'roupa_id.exists' => 'A peça de roupa selecionada não existe no estoque.',
            'quantidade_enviada.min' => 'A quantidade mínima para repasse é 1.',
        ];
    }
}