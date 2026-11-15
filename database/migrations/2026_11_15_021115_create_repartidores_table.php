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
        Schema::create('repartidores', function (Blueprint $table) {
            $table->id('id_repartidor');
            $table->foreignId('id_usuario')->unique()->constrained('usuarios', 'id_usuario')->restrictOnDelete();
            $table->foreignId('id_zona')->nullable()->constrained('zonas', 'id_zona')->restrictOnDelete();
            $table->enum('estado', ['ocupado', 'desconectado','disponible'])->default('disponible');
            $table->decimal('latitud_actual', 10, 7)->nullable();
            $table->decimal('longitud_actual', 10, 7)->nullable();
            $table->timestamp('ultima_actualizacion')->nullable();
            $table->enum('estado_aprobacion', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repartidores');
    }
};
