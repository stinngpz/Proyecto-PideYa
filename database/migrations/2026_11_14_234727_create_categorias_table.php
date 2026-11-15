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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->foreignId('id_departamento')->constrained('departamentos', 'id_departamento')->restrictOnDelete();
            $table->string('nombre', 120);
            $table->integer('orden')->default(0);
            $table->timestamps();
            $table->unique(['id_departamento', 'nombre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
