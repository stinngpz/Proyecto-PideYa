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
        Schema::create('comercio_productos', function (Blueprint $table) {
            $table->id('id_comercio_producto');
            $table->foreignId('id_comercio')->constrained('comercios', 'id_comercio')->restrictOnDelete();
            $table->foreignId('id_producto')->constrained('productos', 'id_producto')->restrictOnDelete();
            $table->decimal('precio', 10, 2);
            $table->string('foto', 255)->nullable();
            $table->boolean('esta_disponible')->default(true);
            $table->integer('stock')->nullable();
            $table->timestamps();
            $table->unique(['id_comercio_producto', 'id_comercio']);
            $table->unique(['id_comercio', 'id_producto']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comercio_productos');
    }
};
