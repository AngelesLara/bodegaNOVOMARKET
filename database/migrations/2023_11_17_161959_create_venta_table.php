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
            $table->decimal('total', 10, 2);
            $table->decimal('pago_con', 10, 2)->default(0);
            $table->string('metodo', 50);
            $table->integer('estado')->default(1);
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_caja');
            $table->unsignedBigInteger('id_forma');
            $table->unsignedBigInteger('id_usuario');
            $table->timestamps();

            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_caja')->references('id')->on('cajas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_forma')->references('id')->on('formas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
