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
        Schema::create('cai', function (Blueprint $table) {
            $table->id('id_cai');
            $table->foreignId('id_comercio')->nullable()->constrained('comercios', 'id_comercio')->restrictOnDelete();
            $table->string('numero_cai', 40)->unique();
            $table->char('establecimiento', 3)->default('000');
            $table->char('punto_emision', 3)->default('001');
            $table->char('tipo_documento', 2)->default('01');
            $table->unsignedInteger('rango_inicial');
            $table->unsignedInteger('rango_final');
            $table->unsignedInteger('correlativo_actual')->default(0);
            $table->date('fecha_limite_emision');
            $table->boolean('activo')->default(true);
            $table->dateTime('fecha_registro')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cai');
    }
};
