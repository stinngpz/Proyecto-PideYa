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
        Schema::create('historial_estado', function (Blueprint $table) {
            $table->id('id_historial');
            $table->foreignId('id_pedido')->constrained('pedidos', 'id_pedido')->cascadeOnDelete();
            $table->foreignId('estado_anterior')->nullable()->constrained('estados_pedido', 'id_estado')->restrictOnDelete();
            $table->foreignId('nuevo_estado')->constrained('estados_pedido', 'id_estado')->restrictOnDelete();
            $table->foreignId('id_usuario')->nullable()->constrained('usuarios', 'id_usuario')->nullOnDelete();
            $table->dateTime('fecha_cambio')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_estado');
    }
};
