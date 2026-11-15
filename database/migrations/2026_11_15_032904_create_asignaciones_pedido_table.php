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
        Schema::create('asignaciones_pedido', function (Blueprint $table) {
            $table->id('id_asignacion');
            $table->foreignId('id_pedido')->constrained('pedidos', 'id_pedido')->cascadeOnDelete();
            $table->foreignId('id_repartidor')->constrained('repartidores', 'id_repartidor')->restrictOnDelete();

            $table->foreignId('id_usuario_asigna')->nullable()->constrained('usuarios', 'id_usuario')->nullOnDelete();

            $table->enum('estado', ['asignada', 'aceptada', 'rechazada', 'cancelada', 'completada'])->default('asignada');
            $table->dateTime('fecha_asignacion')->useCurrent();
            $table->dateTime('fecha_respuesta')->nullable();
            $table->string('motivo_rechazo', 255)->nullable();

            // La base calcula esto sola: 1 si sigue en pie, vacío si la rechazaron o cancelaron
            $table->boolean('es_vigente')->nullable()->storedAs("CASE WHEN estado IN ('asignada', 'aceptada', 'completada') THEN 1 ELSE NULL END");
            $table->timestamps();

            $table->unique(['id_pedido', 'es_vigente']);
            $table->index(['id_repartidor', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaciones_pedido');
    }
};
