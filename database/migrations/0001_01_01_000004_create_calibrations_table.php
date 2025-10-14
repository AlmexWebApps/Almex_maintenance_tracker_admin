<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calibrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catalog_item_id')->constrained()->cascadeOnDelete();
            $table->date('fecha_calibracion');
            $table->string('responsable')->nullable();
            $table->string('reporte')->nullable();
            $table->text('resultados')->nullable();
            $table->boolean('adecuado')->default(true);
            $table->date('fecha_proxima')->nullable();
            $table->date('fecha_maxima')->nullable();
            $table->timestamps();

            $table->index(['catalog_item_id', 'fecha_calibracion']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calibrations');
    }
};
