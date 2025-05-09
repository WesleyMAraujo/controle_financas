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
            $table->unsignedInteger('cartao_id'); // Alterado para unsignedInteger
            $table->foreign('cartao_id')
                  ->references('id')
                  ->on('cartoes')
                  ->onDelete('cascade');
            $table->decimal('valor_parcela', 10, 2);
            $table->decimal('valor_total', 10, 2);
            $table->integer('parcelas_restantes');
            $table->unsignedBigInteger('pessoa_id')->nullable();
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        // Criar uma trigger para calcular o valor_total
        DB::statement('
            CREATE TRIGGER calcular_valor_total_dividas
            BEFORE INSERT ON dividas
            FOR EACH ROW
            BEGIN
                SET NEW.valor_total = NEW.valor_parcela * NEW.parcelas_restantes;
            END
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('dividas');
    }
};
