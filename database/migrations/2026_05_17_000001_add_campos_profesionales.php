<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profesionales', function (Blueprint $table) {
            $table->string('direccion', 500)->nullable()->after('telefono');
            $table->boolean('atiende_presencial')->default(false)->nullable()->after('atiende_domicilio');
            $table->boolean('atiende_solo_comuna')->default(false)->nullable()->after('atiende_presencial');
            $table->text('experiencia_condiciones')->nullable()->after('atiende_solo_comuna');
            $table->smallInteger('anios_experiencia')->nullable()->after('experiencia_condiciones');
            $table->text('especialidades')->nullable()->after('anios_experiencia');
            $table->text('idiomas_comunicacion')->nullable()->after('especialidades');
            $table->text('ambiente_sensorial')->nullable()->after('idiomas_comunicacion');
            $table->text('accesibilidad_fisica')->nullable()->after('ambiente_sensorial');
            $table->boolean('credencial_discapacidad')->default(false)->nullable()->after('accesibilidad_fisica');
            $table->string('registro_profesional')->nullable()->after('credencial_discapacidad');
            $table->string('rango_precios', 100)->nullable()->after('registro_profesional');
            $table->string('instagram_url', 500)->nullable()->after('linkedin_url');
            $table->string('facebook_url', 500)->nullable()->after('instagram_url');
            $table->string('tiktok_url', 500)->nullable()->after('facebook_url');
            $table->string('otra_red_social', 500)->nullable()->after('tiktok_url');
            $table->text('palabras_clave')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('profesionales', function (Blueprint $table) {
            $table->dropColumn([
                'direccion', 'atiende_presencial', 'atiende_solo_comuna',
                'experiencia_condiciones', 'anios_experiencia', 'especialidades',
                'idiomas_comunicacion', 'ambiente_sensorial', 'accesibilidad_fisica',
                'credencial_discapacidad', 'registro_profesional', 'rango_precios',
                'instagram_url', 'facebook_url', 'tiktok_url', 'otra_red_social',
                'palabras_clave',
            ]);
        });
    }
};
