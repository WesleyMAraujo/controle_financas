<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dividas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreignId('cartao_id')->nullable()->constrained('cartoes');
            $table->decimal('valor_parcela', 10, 2);
            $table->integer('parcelas_restantes');
            $table->decimal('valor_total', 10, 2)->virtualAs('valor_parcela * parcelas_restantes');
            $table->foreignId('pessoa_id')->nullable()->constrained('pessoas');
            $table->string('data_inicio');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dividas');
    }
};
