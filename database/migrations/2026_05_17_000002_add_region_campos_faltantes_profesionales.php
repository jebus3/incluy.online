<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Agrega columnas que el schema esperaba pero no existen en la tabla real de Supabase
    public function up(): void
    {
        Schema::table('profesionales', function (Blueprint $table) {
            if (!Schema::hasColumn('profesionales', 'region_id')) {
                $table->uuid('region_id')->nullable();
            }
            if (!Schema::hasColumn('profesionales', 'comuna_id')) {
                $table->uuid('comuna_id')->nullable();
            }
            if (!Schema::hasColumn('profesionales', 'atiende_online')) {
                $table->boolean('atiende_online')->default(false)->nullable();
            }
            if (!Schema::hasColumn('profesionales', 'atiende_domicilio')) {
                $table->boolean('atiende_domicilio')->default(false)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('profesionales', function (Blueprint $table) {
            foreach (['region_id', 'comuna_id', 'atiende_online', 'atiende_domicilio'] as $col) {
                if (Schema::hasColumn('profesionales', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
