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
        Schema::create('configuracion_tarifas', function (Blueprint $table) {
            $table->id('id_config');
            $table->foreignId('id_ciudad')->nullable()->constrained('ciudades', 'id_ciudad')->restrictOnDelete();
            $table->decimal('tarifa_base', 10, 2);
            $table->decimal('costo_por_km', 10, 2);
            $table->decimal('km_incluidos', 10, 2)->default(0);
            $table->decimal('distancia_maxima_km', 10, 2)->nullable();
            $table->decimal('pago_repartidor_por_km', 10, 2)->default(0);
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_tarifas');
    }
};
