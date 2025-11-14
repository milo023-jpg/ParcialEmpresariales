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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();

            // 🔹 Relación con producto (foreign key)
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade')
                  ->comment('Producto que generó la alerta');

            // 🔹 Campos del modelo
            $table->string('mensaje');
            $table->enum('estado', ['activa', 'resuelta'])->default('activa');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
