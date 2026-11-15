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
        Schema::create('carrito_items', function (Blueprint $table) {
            $table->id('id_item');

            // Columnas de las llaves compuestas: solo las columnas, sin relacion aun
            $table->unsignedBigInteger('id_carrito');
            $table->unsignedBigInteger('id_comercio');
            $table->unsignedBigInteger('id_comercio_producto');

            $table->unsignedSmallInteger('cantidad')->default(1);
            $table->foreignId('id_oferta')->nullable()->constrained('ofertas', 'id_oferta')->nullOnDelete();
            $table->string('notas_comercio', 255)->nullable();
            $table->timestamps();

            // Llave compuesta 1: el item pertenece a ESTE carrito de ESTE comercio
            $table->foreign(['id_carrito', 'id_comercio'])->references(['id_carrito', 'id_comercio'])->on('carritos')->cascadeOnDelete();

            // Llave compuesta 2: el producto es de ESTE mismo comercio
            $table->foreign(['id_comercio_producto', 'id_comercio'])->references(['id_comercio_producto', 'id_comercio'])->on('comercio_productos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito_items');
    }
};
