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
        Schema::create('metas_repartidor', function (Blueprint $table) {
            $table->id('id_meta');
            $table->foreignId('id_repartidor')->constrained('repartidores', 'id_repartidor')->cascadeOnDelete();
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->integer('meta_entregas');
            $table->integer('entregas_realizadas')->default(0);
            $table->decimal('bono', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metas_repartidor');
    }
};
