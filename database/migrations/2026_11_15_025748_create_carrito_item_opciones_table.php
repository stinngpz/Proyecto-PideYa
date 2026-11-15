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
        Schema::create('carrito_item_opciones', function (Blueprint $table) {
        $table->foreignId('id_carrito_item')->constrained('carrito_items', 'id_item')->cascadeOnDelete();
        $table->foreignId('id_opcion')->constrained('opciones_producto', 'id_opcion')->cascadeOnDelete();
        $table->timestamps();
        $table->primary(['id_carrito_item', 'id_opcion']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito_item_opciones');
    }
};
