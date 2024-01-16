<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Tarefa_log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function store(Request $request)
    {
        $tarefa_log = new Tarefa_log();
        $tarefa_log->fk_id_tarefa_log = $request->fk_id_tarefa_log;
        $tarefa_log->status = $request->status;
        $tarefa_log->data_hora = $request->data_hora;
       

        if ($request->hasFile('erro')) {
            $tarefa_log->caminho = $request->file('erro')->store('/erro', 'public');  
            $tarefa_log->fk_id_etapa = $request->fk_id_etapa;
            $tarefa_log->nome_etapa = $request->nome_etapa;
        }

        $tarefa_log->save();
        return $tarefa_log;
    }
    public function showAll()
    {
        $tarefaLog = Tarefa_log::select('bot_tarefa_logs.*')
        ->orderBy('bot_tarefa_logs.data_hora','DESC')
        ->get();
        return $tarefaLog;
    }

    public function show($tarefa_log)
    {
        $tarefaID = $tarefa_log;

        $tarefa_Log = Tarefa_log::where('bot_tarefa_logs.fk_id_tarefa_log','=',$tarefaID)
        ->orderBy('bot_tarefa_logs.data_hora','DESC')
        ->get();
        return $tarefa_Log;
    }

    public function show30Days($tarefa_log)
    {
        $tarefaID = $tarefa_log;

        $tarefa_Log = Tarefa_log::where('bot_tarefa_logs.fk_id_tarefa_log','=',$tarefaID)
        ->whereDate('data_hora', '>=', now()->subDays(30))
        ->orderBy('bot_tarefa_logs.data_hora','DESC')
        ->get();
        return $tarefa_Log;
    }
}
