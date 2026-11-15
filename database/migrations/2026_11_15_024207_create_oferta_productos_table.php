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
        Schema::create('oferta_productos', function (Blueprint $table) {
            $table->primary(['id_oferta', 'id_comercio_producto']);
            $table->foreignId('id_oferta')->constrained('ofertas', 'id_oferta')->cascadeOnDelete();
            $table->foreignId('id_comercio_producto')->constrained('comercio_productos', 'id_comercio_producto')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oferta_productos');
    }
};
