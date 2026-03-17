<?php

namespace App\Services;

use App\Models\Roupa;
use App\Models\Repasse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class RepasseService
{
    /**
     * Registra um novo repasse garantindo a consistência do estoque.
     */
    public function registrarRepasse(array $dados)
    {
        // Abrimos a Transação (Atomicidade: Tudo ou Nada)
        return DB::transaction(function () use ($dados) {
            
            // 1. Busca a roupa e GARANTE que ela pertence ao distribuidor logado
            $roupa = Roupa::where('id', $dados['roupa_id'])
                          ->where('user_id', Auth::id()) // 
                          ->lockForUpdate()
                          ->firstOrFail();

            // 2. Regra de Negócio: Tem estoque suficiente?
            if ($roupa->quantidade_estoque < $dados['quantidade_enviada']) {
                throw new Exception('Estoque insuficiente para realizar este repasse.');
            }

            // 3. Subtrai o estoque da matriz e salva
            $roupa->quantidade_estoque -= $dados['quantidade_enviada'];
            $roupa->save();

            // 4. Cria o histórico de repasse para a vendedora
            $repasse = Repasse::create([
                'vendedora_id' => $dados['vendedora_id'],
                'roupa_id' => $roupa->id,
                'quantidade_enviada' => $dados['quantidade_enviada'],
                'quantidade_devolvida' => 0,
                'quantidade_vendida' => 0,
                'data_repasse' => $dados['data_repasse'],
            ]);

            return $repasse;
        });
    }
}