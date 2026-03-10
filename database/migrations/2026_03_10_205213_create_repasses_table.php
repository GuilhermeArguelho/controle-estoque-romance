<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repasses', function (Blueprint $table) {
            $table->id();
            // Chaves estrangeiras conectando as tabelas
            $table->foreignId('vendedora_id')->constrained()->onDelete('cascade');
            $table->foreignId('roupa_id')->constrained()->onDelete('cascade');
            
            $table->integer('quantidade_enviada');
            $table->integer('quantidade_devolvida')->default(0);
            $table->integer('quantidade_vendida')->default(0);
            $table->date('data_repasse');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repasses');
    }
};
