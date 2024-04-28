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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 10, 2);
            $table->text('descripcion');
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('id_caja');
            $table->unsignedBigInteger('id_usuario');
            $table->timestamps();
            $table->foreign('id_caja')->references('id')->on('cajas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
