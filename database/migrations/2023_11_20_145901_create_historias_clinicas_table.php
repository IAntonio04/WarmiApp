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
        Schema::create('historias_clinicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('medico_id');
            $table->unsignedBigInteger('cita_id')->nullable();
            $table->text('titulo');
            $table->text('diagnostico')->nullable();
            $table->string('archivo_adjunto_path')->nullable();
            $table->enum('tipo', ['Inicial', 'Perinatal']);
            $table->timestamps();
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('medico_id')->references('id')->on('medicos');
            $table->foreign('cita_id')->references('id')->on('citas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historias_clinicas');
    }
};
