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
            $table->decimal('monto_inicial', 10, 2);
            $table->dateTime('fecha_apertura');
            $table->dateTime('fecha_cierre')->nullable();
            $table->decimal('compras', 10, 2)->default(0);
            $table->decimal('gastos', 10, 2)->default(0);
            $table->decimal('ventas', 10, 2)->default(0);
            $table->integer('estado')->default(1);
            $table->unsignedBigInteger('id_usuario');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
