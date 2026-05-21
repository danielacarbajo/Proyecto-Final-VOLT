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
    Schema::create('detalle_entrenamiento', function (Blueprint $table) {
        $table->id();
        $table->foreignId('entrenamiento_id')->constrained('entrenamientos')->onDelete('cascade');
        $table->foreignId('ejercicio_id')->constrained('ejercicios')->onDelete('cascade');
        $table->unsignedSmallInteger('series');
        $table->unsignedSmallInteger('repeticiones');
        $table->decimal('peso', 6, 2);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_entrenamiento');
    }
};
