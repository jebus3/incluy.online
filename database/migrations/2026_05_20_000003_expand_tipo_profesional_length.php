<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE profesionales ALTER COLUMN tipo_profesional TYPE varchar(255)');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE profesionales ALTER COLUMN tipo_profesional TYPE varchar(40)');
    }
};
