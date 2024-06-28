<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('clases', function (Blueprint $table) {
        $table->id();
        $table->string('categoria');
        $table->string('instructor');
        $table->integer('cupos_totales');
        $table->integer('duracion');
        $table->date('fecha_inicio');
        $table->time('hora_inicio');
        $table->time('hora_fin');
        $table->decimal('costo_inscripcion', 8, 2);
        $table->text('informacion');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases');
    }
};
