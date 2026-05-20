<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // El CHECK constraint limita tipo_profesional a una lista fija de valores.
        // Se elimina para permitir texto libre desde el admin.
        DB::statement('ALTER TABLE profesionales DROP CONSTRAINT IF EXISTS profesionales_tipo_profesional_check');
    }

    public function down(): void
    {
        // No se restaura — los valores libres ya estarían en la tabla.
    }
};
