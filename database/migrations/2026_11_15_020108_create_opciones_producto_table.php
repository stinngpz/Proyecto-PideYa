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
        Schema::create('opciones_producto', function (Blueprint $table) {
            $table->id('id_opcion');
            $table->foreignId('id_grupo')->constrained('grupos_opciones', 'id_grupo')->cascadeOnDelete();
            $table->string('nombre', 120);
            $table->decimal('precio_adicional', 10, 2)->default(0);
            $table->boolean('esta_disponible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opciones_producto');
    }
};
