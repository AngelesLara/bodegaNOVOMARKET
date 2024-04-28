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
        Schema::create('detallecotizacion', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio', 10, 2);
            $table->integer('cantidad');
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_cotizacion');
            $table->timestamps();

            $table->foreign('id_cotizacion')->references('id')->on('cotizaciones')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detallecotizacion');
    }
};
