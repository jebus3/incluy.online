<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emprendimientos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre_marca');
            $table->string('slug')->unique();
            $table->string('nombre_encargados');
            $table->string('rut', 20)->nullable();
            $table->string('categoria', 100);
            $table->text('historia')->nullable();
            $table->string('tipo_liderazgo', 50)->nullable(); // persona_discapacidad | cuidador | inclusivo
            $table->text('producto_servicio_adaptado')->nullable();
            $table->boolean('emplea_personas_discapacidad')->default(false);
            $table->text('accesibilidad_compra')->nullable();
            $table->string('alcance_envios', 50)->nullable(); // solo_comuna | region | todo_chile
            $table->text('punto_retiro')->nullable();
            $table->text('accesibilidad_local')->nullable();
            $table->string('metodos_pago', 255)->nullable();
            $table->boolean('resolucion_sanitaria')->nullable();
            $table->text('idiomas_comunicacion')->nullable();
            $table->text('ambiente_sensorial')->nullable();
            $table->text('accesibilidad_fisica')->nullable();
            $table->boolean('credencial_discapacidad')->default(false);
            $table->string('sitio_web', 500)->nullable();
            $table->string('email_contacto')->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('instagram_url', 500)->nullable();
            $table->string('facebook_url', 500)->nullable();
            $table->string('tiktok_url', 500)->nullable();
            $table->string('otra_red_social', 500)->nullable();
            $table->string('foto_url', 500)->nullable();
            $table->uuid('region_id')->nullable();
            $table->uuid('comuna_id')->nullable();
            $table->boolean('verificado')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emprendimientos');
    }
};
