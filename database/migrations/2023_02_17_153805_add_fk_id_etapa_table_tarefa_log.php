<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkIdEtapaTableTarefaLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarefa_logs', function (Blueprint $table) {
            $table->Integer('fk_id_etapa')->unsigned();
            $table->foreign('fk_id_etapa')->references('pk_id_etapa')->on('etapas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarefa_logs', function (Blueprint $table) {
            $table->dropColumn('fk_id_etapa');
        });
    }
}
