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
    Schema::create('detalle_rutina', function (Blueprint $table) {
        $table->id();
        $table->foreignId('rutina_id')->constrained('rutinas')->onDelete('cascade');
        $table->foreignId('ejercicio_id')->constrained('ejercicios')->onDelete('cascade');
        $table->unsignedSmallInteger('series_por_defecto')->default(3);
        $table->unsignedSmallInteger('repeticiones_por_defecto')->default(10);
        $table->unsignedSmallInteger('posicion');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_rutina');
    }
};
