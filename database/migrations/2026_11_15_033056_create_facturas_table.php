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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id('id_factura');
            $table->foreignId('id_pedido')->constrained('pedidos', 'id_pedido')->restrictOnDelete();
            $table->foreignId('id_cai')->constrained('cai', 'id_cai')->restrictOnDelete();
            $table->char('correlativo', 16)->unique();
            $table->string('numero_cai', 40);
            $table->char('correlativo', 16);
            $table->char('rtn_cliente', 14)->nullable();
            $table->string('nombre_cliente', 160)->default('Consumidor Final');
            $table->char('rtn_comercio', 14);
            $table->decimal('importe_comida', 10, 2);
            $table->decimal('importe_envio', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('importe_gravado_15', 10, 2);
            $table->decimal('importe_exento', 10, 2)->default(0);
            $table->decimal('importe_exonerado', 10, 2)->default(0);
            $table->decimal('isv_15', 10, 2);
            $table->decimal('propina', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['emitida', 'anulada'])->default('emitida');
            $table->boolean('es_vigente')->storedAs("case when estado = 'emitida' then 1 else null end");
            $table->dateTime('fecha_emision')->useCurrent();
            $table->timestamps();
            $table->unique(['id_pedido', 'es_vigente']);
            $table->unique(['id_cai', 'correlativo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};