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
        Schema::create('parcelas_dividas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('divida_id')->constrained('dividas');
            $table->foreignId('status_id')->constrained('status');
            $table->string('parcela'); // Armazenar como string no formato MM-AAAA
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcelas_dividas');
    }
};
