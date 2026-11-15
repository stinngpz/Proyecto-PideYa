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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id('id_direccion');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->restrictOnDelete();
            $table->foreignId('id_zona')->constrained('zonas', 'id_zona')->restrictOnDelete();
            $table->string('nombre', 60);
            $table->decimal('latitud_envio', 10, 7);
            $table->decimal('longitud_envio', 10, 7);
            $table->string('detalle_calle',255);
            $table->string('referencia',250);
            $table->boolean('es_predeterminada')->default(false);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
