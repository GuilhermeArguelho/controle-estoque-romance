<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRepasseRequest;
use App\Services\RepasseService;
use App\Models\Roupa;
use App\Models\Vendedora;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Exception;

class RepasseController extends Controller
{
    protected $repasseService;

    public function __construct(RepasseService $repasseService)
    {
        $this->repasseService = $repasseService;
    }

    public function create()
    {
        // 1. Buscamos as roupas e vendedoras APENAS do distribuidor logado (Regra SaaS)
        $roupas = Roupa::where('user_id', Auth::id())->where('quantidade_estoque', '>', 0)->get();
        $vendedoras = Vendedora::where('user_id', Auth::id())->get();

        // 2. O Inertia.js pega esses dados do PHP e joga direto para o React
        return Inertia::render('Repasses/Create', [
            'roupas' => $roupas,
            'vendedoras' => $vendedoras
        ]);
    }

    /**
     * Método STORE: Recebe os dados quando o usuário clica em "Salvar" no React.
     * * Veja que passamos o `StoreRepasseRequest` em vez do `Request` padrão.
     * Isso significa que o Laravel SÓ vai deixar o código entrar nessa função 
     * se os dados passarem pela nossa barreira de segurança!
     */
    public function store(StoreRepasseRequest $request)
    {
        try {
            // 1. Pegamos apenas os dados limpos e validados
            $dadosValidados = $request->validated();

            // 2. Mandamos o "Recepcionista" chamar o "Cérebro" para fazer o trabalho pesado
            $this->repasseService->registrarRepasse($dadosValidados);

            // 3. Se deu tudo certo, redirecionamos a página com uma mensagem de sucesso
            return redirect()->back()->with('success', 'Repasse registrado com sucesso!');
            
        } catch (Exception $e) {
            // 4. Se o Service estourou um erro (ex: "Estoque insuficiente"),
            // nós capturamos (catch) e devolvemos o erro para a tela do React.
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}