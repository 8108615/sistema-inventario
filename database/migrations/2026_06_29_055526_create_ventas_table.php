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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('caja_id')->constrained()->cascadeOnDelete(); // Relación clave
            $table->enum('tipo_comprobante', ['Boleta', 'Factura'])->default('Boleta');
            $table->string('numero_comprobante')->unique();
            $table->enum('metodo_pago', ['EFECTIVO', 'TARJETA', 'TRASFERENCIA']);
            $table->dateTime('fecha_hora');
            $table->decimal('subtotal', 10, 2, true); // Ampliado a 10 para mayor seguridad
            $table->decimal('impuesto', 10, 2, true);
            $table->decimal('total', 10, 2, true);
            $table->decimal('monto_recibido', 10, 2, true);
            $table->decimal('vuelto_entregado', 10, 2, true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
