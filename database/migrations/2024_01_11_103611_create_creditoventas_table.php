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
        Schema::create('creditoventas', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 10, 2);
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_venta');
            $table->unsignedBigInteger('id_usuario');
            $table->timestamps();

            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_venta')->references('id')->on('ventas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creditoventas');
    }
};
