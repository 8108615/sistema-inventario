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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('propietario');
            $table->string('nit', 50);
            $table->integer('porcentaje_impuesto')->unsigned();
            $table->string('abreviatura_impuesto', 5);
            $table->string('direccion');
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();
            $table->string('divisa');
            $table->string('logo')->nullable();
            $table->string('web')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
