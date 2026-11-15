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
        Schema::create('carritos', function (Blueprint $table) {
            $table->id('id_carrito');
            $table->foreignId('id_cliente')->unique()->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->foreignId('id_comercio')->constrained('comercios', 'id_comercio')->restrictOnDelete();
            $table->dateTime('expira_en');
            $table->unique(['id_carrito', 'id_comercio']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carritos');
    }
};
