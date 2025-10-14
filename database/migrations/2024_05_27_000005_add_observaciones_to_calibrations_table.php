<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calibrations', function (Blueprint $table) {
            $table->text('observaciones')->nullable()->after('resultados');
        });
    }

    public function down(): void
    {
        Schema::table('calibrations', function (Blueprint $table) {
            $table->dropColumn('observaciones');
        });
    }
};
