<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarefaHorario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefa_horario', function (Blueprint $table) {
            $table->bigIncrements('pk_id_tarefa_horario');
            $table->Integer('fk_id_tarefa')->unsigned();
            $table->foreign('fk_id_tarefa')->references('pk_id_tarefa')->on('tarefas');
            $table->timestamp('data_hora_executar');
            $table->text('dia_da_semana');
            $table->text('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarefa_horario');
    }
}
