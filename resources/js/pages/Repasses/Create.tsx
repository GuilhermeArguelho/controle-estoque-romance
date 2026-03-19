import { Head, useForm } from '@inertiajs/react';
import React from 'react';


declare function route(name: string, params?: any, absolute?: boolean): string;

// 1. O CONTRATO DA VENDEDORA
interface Vendedora {
    id: number;
    nome: string;
}

// 2. O CONTRATO DA ROUPA
interface Roupa {
    id: number;
    tipo: string;
    tamanho: string;
    quantidade_estoque: number;
}

// 3. O CONTRATO DA TELA (Props)
interface CreateProps {
    roupas: Roupa[];
    vendedoras: Vendedora[];
}

export default function Create({ roupas, vendedoras }: CreateProps) {
    const { data, setData, post, processing, errors } = useForm({
        vendedora_id: '',
        roupa_id: '',
        quantidade_enviada: '',
        data_repasse: new Date().toISOString().split('T')[0],
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('repasses.store')); 
    };

    return (
        <div className="min-h-screen bg-gray-50 pb-10">
            <Head title="Novo Repasse" />

            <header className="bg-pink-600 shadow-md p-4 sticky top-0 z-10">
                <h1 className="text-xl font-bold text-white text-center">
                    Novo Repasse
                </h1>
            </header>

            <main className="max-w-md mx-auto mt-6 px-4">
                <form onSubmit={handleSubmit} className="bg-white rounded-xl shadow-sm p-5 space-y-6">
                    
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            Vendedora
                        </label>
                        <select
                            value={data.vendedora_id}
                            onChange={(e) => setData('vendedora_id', e.target.value)}
                            className="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500 text-base py-3"
                        >
                            <option value="">Selecione a vendedora...</option>
                            {vendedoras && vendedoras.map((v) => (
                                <option key={v.id} value={v.id}>{v.nome}</option>
                            ))}
                        </select>
                        {errors.vendedora_id && <div className="text-red-500 text-xs mt-1">{errors.vendedora_id}</div>}
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            Peça de Roupa
                        </label>
                        <select
                            value={data.roupa_id}
                            onChange={(e) => setData('roupa_id', e.target.value)}
                            className="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500 text-base py-3"
                        >
                            <option value="">Selecione a peça (Estoque)...</option>
                            {roupas && roupas.map((r) => (
                                <option key={r.id} value={r.id}>
                                    {r.tipo} {r.tamanho} (Disponível: {r.quantidade_estoque})
                                </option>
                            ))}
                        </select>
                        {errors.roupa_id && <div className="text-red-500 text-xs mt-1">{errors.roupa_id}</div>}
                    </div>

                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-1">
                                Qtd. Enviada
                            </label>
                            <input
                                type="number"
                                min="1"
                                value={data.quantidade_enviada}
                                onChange={(e) => setData('quantidade_enviada', e.target.value)}
                                className="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500 text-base py-3"
                            />
                            {errors.quantidade_enviada && <div className="text-red-500 text-xs mt-1">{errors.quantidade_enviada}</div>}
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-1">
                                Data
                            </label>
                            <input
                                type="date"
                                value={data.data_repasse}
                                onChange={(e) => setData('data_repasse', e.target.value)}
                                className="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500 text-base py-3"
                            />
                            {errors.data_repasse && <div className="text-red-500 text-xs mt-1">{errors.data_repasse}</div>}
                        </div>
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="w-full bg-pink-600 text-white font-bold py-4 rounded-lg shadow-md hover:bg-pink-700 transition-colors disabled:opacity-50 text-lg mt-4"
                    >
                        {processing ? 'Registrando...' : 'Confirmar Repasse'}
                    </button>
                </form>
            </main>
        </div>
    );
}