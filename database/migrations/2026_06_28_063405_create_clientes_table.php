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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cliente');
            $table->enum('tipo_persona', ['Natural', 'Juridico'])->default('Natural');
            $table->string('razon_social')->nullable();
            $table->string('nit', 20)->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono', 15)->nullable();
            $table->string('email')->nullable();
            $table->string('tipo_documento', 20); // Ejemplo: CI, NIT, Pasaporte
            $table->string('numero_documento', 20);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
