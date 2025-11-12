<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instrument_events', function (Blueprint $table) {
            $table->id();

            // Relación con el instrumento
            $table->foreignId('instrument_id')->constrained('intruments')->cascadeOnDelete();

            // Tipo de evento
            $table->enum('event_type', [
                'CALIBRACION',
                'VALIDACION',
                'MANTENIMIENTO'
            ]);

            // Datos comunes
            $table->date('fecha_evento');              // fecha de calibración/verificación/mantenimiento
            $table->string('responsable')->nullable();
            $table->string('reporte')->nullable();     // archivo o folio del reporte
            $table->text('resultados')->nullable();    // observaciones o resultados
            $table->boolean('adecuado')->default(true);

            // Próximas fechas
            $table->date('fecha_proxima')->nullable();
            $table->date('fecha_maxima')->nullable();

            $table->timestamps();

            $table->index(['instrument_id', 'event_type', 'fecha_evento']);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('instrument_events');
    }
};
