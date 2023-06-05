<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Tarefa_log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tarefa_log = new Tarefa_log();
        $tarefa_log->fk_id_tarefa = $request->fk_id_tarefa;
        $tarefa_log->fk_id_etapa = $request->fk_id_etapa;
        $tarefa_log->nome_etapa = $request->nome_etapa;
        $tarefa_log->caminho = $request->file('erro')->store('/erro','public');
        $tarefa_log->status = $request->status;
        $tarefa_log->data_hora = $request->data_hora;
        $tarefa_log->save();

        return $tarefa_log;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        $tarefaLog = Tarefa_log::select('bot_tarefa_logs.*')
        ->orderBy('bot_tarefa_logs.data_hora','DESC')
        ->get();

        // $consultaEtapa = Etapa::where('bot_etapas.fk_id_tarefa', '=', $tarefaID)
        //     ->select('bot_etapas.*')
        //     ->orderBy('bot_etapas.ordem')
        //     ->get();
        return $tarefaLog;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
