<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\NullableType;

class Etapa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etapas', function (Blueprint $table) {
            $table->bigIncrements('pk_id_etapa');
            $table->bigInteger('fk_id_tarefa')->unsigned();
            $table->foreign('fk_id_tarefa')->references('pk_id_tarefa')->on('tarefas')->onDelete('cascade');
            $table->text('nome_etapa');
            $table->text('acao');
            $table->integer('tempo_execucao');
            $table->text('digitar')->Nullable;
            $table->text('caminho');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etapas');
    }
}
