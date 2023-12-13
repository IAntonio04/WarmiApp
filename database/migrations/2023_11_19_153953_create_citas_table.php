<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medico_id');
            $table->unsignedBigInteger('paciente_id');
            $table->dateTime('fecha_hora');
            $table->string('motivo_consulta');
            $table->enum('estado', ['Pendiente', 'Confirmada', 'Atendida', 'Cancelada']);
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('medico_id')->references('id')->on('medicos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('citas');
    }
}
// $table->string("title",255);
// $table->text("descripcion");
// $table->string("color",20);
// $table->string("textColor",20);
// $table->dateTime("start");
// $table->dateTime("end");