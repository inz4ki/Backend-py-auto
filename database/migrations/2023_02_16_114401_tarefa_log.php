<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TarefaLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefa_logs', function (Blueprint $table) {
            $table->bigIncrements('pk_id_tarefa_log');
            $table->integer('fk_id_tarefa')->unsigned();
            $table->foreign('fk_id_tarefa')->references('pk_id_tarefa')->on('tarefas');
            $table->text('nome_etapa');
            $table->text('caminho');
            $table->text('status');
            $table->time('hora');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarefa_logs');
    }
}
