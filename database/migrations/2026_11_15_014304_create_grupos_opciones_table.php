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
        Schema::create('grupos_opciones', function (Blueprint $table) {
            $table->id('id_grupo');
            $table->foreignId('id_comercio_producto')->constrained('comercio_productos', 'id_comercio_producto')->cascadeOnDelete();
            $table->string('nombre', 120);
            $table->enum('tipo', ['unica', 'multiple'])->default('unica');
            $table->boolean('obligatorio')->default(false);
            $table->unsignedTinyInteger('max_opciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos_opciones');
    }
};
