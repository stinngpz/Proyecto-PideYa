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
        Schema::create('comisiones', function (Blueprint $table) {
            $table->id('id_comision');
            $table->foreignId('id_pedido')->unique()->constrained('pedidos', 'id_pedido')->restrictOnDelete();
            $table->foreignId('id_comercio')->constrained('comercios', 'id_comercio')->restrictOnDelete();
            $table->decimal('porcentaje', 5, 2);
            $table->decimal('base_comision', 10, 2);
            $table->decimal('monto_comision', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comisiones');
    }
};
