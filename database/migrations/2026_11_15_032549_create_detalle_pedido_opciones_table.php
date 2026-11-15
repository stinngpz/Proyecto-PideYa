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
        Schema::create('detalle_pedido_opciones', function (Blueprint $table) {
            $table->foreignId('id_detalle')->constrained('detalle_pedido', 'id_detalle')->cascadeOnDelete();
            $table->foreignId('id_opcion')->constrained('opciones_producto', 'id_opcion')->restrictOnDelete();
            $table->string('nombre_opcion', 120);
            $table->decimal('precio_adicional', 10, 2)->default(0);
            $table->timestamps();

            $table->primary(['id_detalle', 'id_opcion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedido_opciones');
    }
};
