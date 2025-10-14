<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catalog_items', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->enum('tipo_item', ['INSTRUMENTO', 'PLANO']);
            $table->string('equipo');
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->boolean('requiere_calibracion')->default(true);
            $table->enum('tipo', ['NO_CRITICO', 'CRITICO'])->default('NO_CRITICO');
            $table->enum('estado', ['BAJA', 'MEDIA', 'ALTA'])->default('BAJA');
            $table->decimal('emt_valor', 12, 4)->nullable();
            $table->string('emt_unidad')->nullable();
            $table->boolean('emt_simetrico')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('forma')->nullable();

            // Snapshot de última calibración
            $table->date('ult_fecha_ultima')->nullable();
            $table->date('ult_fecha_proxima')->nullable();
            $table->date('ult_fecha_maxima')->nullable();
            $table->integer('ult_dias_retraso')->nullable();
            $table->string('ult_calibro')->nullable();
            $table->string('ult_reporte')->nullable();
            $table->text('ult_resultados')->nullable();
            $table->boolean('ult_adecuado_uso')->nullable();
            $table->text('ult_observaciones')->nullable();

            $table->timestamps();
            $table->index(['tipo_item', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalog_items');
    }
};
