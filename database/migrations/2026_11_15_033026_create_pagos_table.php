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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('id_pago');
            $table->foreignId('id_pedido')->constrained('pedidos', 'id_pedido')->restrictOnDelete();
            $table->foreignId('id_cupon')->nullable()->constrained('cupones', 'id_cupon')->nullOnDelete();
            $table->enum('metodo', [ 'tarjeta', 'simulado']);
            $table->decimal('monto', 10, 2);
            $table->string('transaccion_id', 80)->nullable();
            $table->enum('estado', ['pendiente', 'pagado', 'fallido', 'reembolsado'])->default('pendiente');
            $table->dateTime('fecha_pago')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
