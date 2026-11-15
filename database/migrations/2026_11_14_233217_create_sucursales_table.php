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
        Schema::create('sucursales', function (Blueprint $table) {
            $table->id('id_sucursal');
            $table->foreignId('id_comercio')->constrained('comercios', 'id_comercio')->restrictOnDelete();
            $table->foreignId('id_zona')->constrained('zonas', 'id_zona')->restrictOnDelete();
            $table->string('nombre', 120);
            $table->string('direccion', 255);
            $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);
            $table->string('telefono', 20);
            $table->boolean('esta_activa')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursales');
    }
};
