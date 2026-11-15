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
        Schema::create('seguimiento_repartidor', function (Blueprint $table) {
            $table->id('id_seguimiento_repartidor');
            $table->foreignId('id_asignacion')->constrained('asignaciones_pedido', 'id_asignacion')->cascadeOnDelete();
            $table->enum('evento', ['ubicacion', 'retiro_comercio', 'entrega_cliente'])->default('ubicacion');
            $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);
            $table->string('nota', 255)->nullable();
            $table->dateTime('registrado_en')->useCurrent();
            $table->timestamps();

            $table->index(['id_asignacion', 'registrado_en']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimiento_repartidor');
    }
};
