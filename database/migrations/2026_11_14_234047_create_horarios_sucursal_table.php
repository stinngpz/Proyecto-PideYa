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
        Schema::create('horarios_sucursal', function (Blueprint $table) {
            $table->id('id_horario_sucursal');
            $table->foreignId('id_sucursal')->constrained('sucursales', 'id_sucursal')->cascadeOnDelete();
            $table->enum('dia_semana', ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo']);
            $table->time('hora_apertura');
            $table->time('hora_cierre');
            $table->unique(['id_sucursal', 'dia_semana']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios_sucursal');
    }
};
