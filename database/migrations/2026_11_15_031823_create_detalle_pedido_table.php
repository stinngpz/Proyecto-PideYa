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
        Schema::create('detalle_pedido', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->unsignedBigInteger('id_pedido');
            $table->unsignedBigInteger('id_comercio');
            $table->unsignedBigInteger('id_comercio_producto');
            $table->foreignId('id_oferta')->nullable()->constrained('ofertas', 'id_oferta')->nullOnDelete();
            $table->string('nombre_producto', 120);
            $table->unsignedSmallInteger('cantidad');
            $table->decimal('precio_normal', 10, 2);
            $table->decimal('precio_oferta', 10, 2)->nullable();
            $table->decimal('subtotal_linea', 10, 2);
            $table->decimal('descuento_linea', 10, 2)->storedAs('cantidad * (precio_normal - coalesce(precio_oferta, precio_normal))');
            $table->string('notas_comercio', 255)->nullable();
            $table->timestamps();
            $table->foreign(['id_pedido', 'id_comercio'])->references(['id_pedido', 'id_comercio'])->on('pedidos')->cascadeOnDelete();
            $table->foreign(['id_comercio_producto', 'id_comercio'])->references(['id_comercio_producto', 'id_comercio'])->on('comercio_productos')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedido');
    }
};