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
        Schema::create('comercios', function (Blueprint $table) {
            $table->id('id_comercio');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->restrictOnDelete();
            $table->foreignId('id_tipo_comercio')->constrained('tipos_comercio', 'id_tipo_comercio')->restrictOnDelete();
            $table->string('nombre',120);
            $table->char('rtn',14);
            $table->text('descripcion');
            $table->string('logo',255)->nullable();
            $table->string('banner',255)->nullable();
            $table->integer('tiempo_promedio_min')->default(30);
            $table->decimal('costo_delivery_base',10,2)->default(0);
            $table->decimal('porcentaje_comision',5,2)->default(15.00);
            $table->enum('estado_aprobacion', ['pendiente', 'aprobado', 'suspendido'])->default('pendiente');
            $table->boolean('esta_activado')->default(true);
            $table->decimal('calificacion',3,2)->default(0);
            $table->index(['estado_aprobacion', 'esta_activado']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comercios');
    }
};
