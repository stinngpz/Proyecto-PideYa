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
        Schema::create('oferta_aplicada', function (Blueprint $table) {
            $table->id('id_oferta_aplicada');
            $table->foreignId('id_oferta')->constrained('ofertas', 'id_oferta')->restrictOnDelete();
            $table->foreignId('id_pedido')->constrained('pedidos', 'id_pedido')->cascadeOnDelete();
            $table->decimal('monto_descuento', 10, 2);
            $table->timestamps();
            $table->unique(['id_oferta', 'id_pedido']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oferta_aplicada');
    }
};
