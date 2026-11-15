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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('id_pedido');
            $table->foreignId('id_cliente')->constrained('usuarios', 'id_usuario')->restrictOnDelete();
            $table->foreignId('id_comercio')->constrained('comercios', 'id_comercio')->restrictOnDelete();
            $table->foreignId('id_sucursal')->constrained('sucursales', 'id_sucursal')->restrictOnDelete();
            $table->foreignId('id_direccion')->nullable()->constrained('direcciones', 'id_direccion')->nullOnDelete();
            $table->foreignId('id_estado')->default(1)->constrained('estados_pedido', 'id_estado')->restrictOnDelete();
            $table->decimal('latitud_entrega', 10, 7);
            $table->decimal('longitud_entrega', 10, 7);
            $table->string('direccion_entrega', 255);
            $table->string('instrucciones_entrega', 255)->nullable();
            $table->decimal('distancia_km', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tarifa_envio', 10, 2);
            $table->decimal('pago_repartidor', 10, 2)->default(0);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('base_gravada', 10, 2);
            $table->decimal('isv', 10, 2);
            $table->decimal('propina', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->integer('eta_minutos')->nullable();
            $table->string('motivo_cancelacion', 255)->nullable();
            $table->dateTime('fecha_creacion')->useCurrent();
            $table->dateTime('fecha_entrega')->nullable();
            $table->timestamps();
            $table->unique(['id_pedido', 'id_comercio']);
            $table->index(['id_cliente', 'id_estado']);
            $table->index(['id_comercio', 'id_estado']);
            $table->index('fecha_creacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
