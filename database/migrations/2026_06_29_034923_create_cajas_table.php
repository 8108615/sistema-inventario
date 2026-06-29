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
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_caja', 50)->default('Caja Principal');
            $table->dateTime('fecha_hora_apertura');
            $table->dateTime('fecha_hora_cierre')->nullable();
            $table->decimal('saldo_inicial', 10, 2);
            $table->decimal('saldo_final', 10, 2)->nullable();
            $table->boolean('estado')->default(true);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};
