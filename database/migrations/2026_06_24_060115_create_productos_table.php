<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            // Relación
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');

            // Identificación
            $table->string('codigo_producto', 50)->unique();
            $table->string('codigo_barra', 50)->unique();
            $table->string('nombre_producto', 100);
            $table->text('descripcion');
            $table->string('imagen')->nullable();

            // Valores y Stock
            $table->decimal('precio_compra', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->integer('stock_actual')->default(0);
            $table->integer('stock_minimo')->default(0);
            $table->integer('stock_maximo')->default(0);
            $table->string('unidad_medida')->default('unidad');
            $table->boolean('estado')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
