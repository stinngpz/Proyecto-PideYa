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
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id('id_oferta');
            $table->foreignId('id_comercio')->nullable()->constrained('comercios', 'id_comercio')->restrictOnDelete();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->string('codigo_cupon', 50)->nullable()->unique();
            $table->enum('tipo_descuento', ['porcentaje', 'monto']);
            $table->decimal('descuento', 10, 2);
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->text('condiciones')->nullable();
            $table->decimal('monto_minimo', 10, 2)->default(0);
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};
