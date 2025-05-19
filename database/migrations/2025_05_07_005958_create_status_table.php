<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps();
            $table->softDeletes();
        });

        // Inserir os status iniciais
        DB::table('status')->insert([
            ['nome' => 'À Pagar', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Pago', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Reservado', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('status');
    }
};
