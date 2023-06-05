<?php

namespace App\Http\Controllers;

use App\Models\Etapa;
use Illuminate\Http\Request;
use App\Models\Tarefa;
use Carbon\Carbon;
use DateTime;

class TarefaController extends Controller
{

    public function store(Request $request)
    {
        $tarefa = new Tarefa();
        $tarefa->nome_tarefa = $request->nome_tarefa;
        $tarefa->hora_executar = $request->hora_executar;
        $tarefa->dia_da_semana = $request->dia_da_semana;
        $tarefa->estado = $request->estado;
        $tarefa->save();

        return $tarefa;
    }


    public function showAll()
    {
        $tarefa = Tarefa::all();
        return $tarefa;
    }

    public function show(Tarefa $tarefa)
    {
        return $tarefa;
    }

    public function update(Request $request, Tarefa $tarefa)
    {
        $tarefa->estado = $request->estado;
        $tarefa->save();

        return 'ok';
    }

    public function atualizarTarefa(Request $request, Tarefa $tarefa)
    {
        $tarefa->dia_da_semana = $request->dia_da_semana;
        $tarefa->hora_executar = $request->hora_executar;
        $tarefa->nome_tarefa = $request->nome_tarefa;
        $tarefa->estado = $request->estado;
        $tarefa->save();

        return $request;
    }

    public function reiniciarCampoEstado()
    { 
        $tarefa = Tarefa::where('estado', '!=', 'não executado')
        ->where('estado', '!=', 'Desativado')
        ->update(['estado' => 'não executado']); 
       
        return $tarefa;
    }

    public function reiniciarCampoEstadoComID(Request $request)
    {
        $tarefaID = $request->tarefa;
        $tarefa = Tarefa::where('pk_id_tarefa', '=', $tarefaID)
            ->update(['estado' => 'não executado']);
        return $tarefa;
    }
    public function desativarCampoEstadoComID(Request $request)
    {
        $tarefaID = $request->tarefa;
        $tarefa = Tarefa::where('pk_id_tarefa', '=', $tarefaID)
            ->update(['estado' => 'Desativado']);
        return $tarefa;
    }

    public function destroy(Tarefa $tarefa)
    {
        $tarefa->delete();
        return "deletado com Sucesso";
    }

    public function pesquisarTarefasParaExecutar()
    {
        Carbon::setLocale('pt');
        $horaAtual = Carbon::now();
        $nomeDia = Carbon::now()->translatedFormat('D');
        $executando = Tarefa::where('estado', '=', 'executando')->get();
        if (!$executando->isEmpty()) {
            echo $executando;
        } else {
            $ConsultarTarefa = Tarefa::where('hora_executar', '<', $horaAtual)
                ->where('estado', '=', 'não executado')
                ->where('dia_da_semana', 'LIKE', "%{$nomeDia}%")
                ->orderBy('hora_executar')
                ->first();
            echo $ConsultarTarefa;
        }
    }

    public function duplicate(Request $request)
    {
        $tarefaId = $request->pk_id_tarefa;

        $tarefa = new Tarefa();
        $tarefa->nome_tarefa = $request->nome_tarefa;
        $tarefa->hora_executar = $request->hora_executar;
        $tarefa->dia_da_semana = $request->dia_da_semana;
        $tarefa->estado = $request->estado;
        $tarefa->save();

        $cloneTarefaId = $tarefa->pk_id_tarefa;

        $etapaSalvar = Etapa::where('bot_etapas.fk_id_tarefa', '=', $tarefaId)
            ->get();

        foreach ($etapaSalvar as $row) {
            $etapa = new Etapa();
            $etapa->nome_etapa = $row['nome_etapa'];
            $etapa->fk_id_tarefa = $cloneTarefaId;
            $etapa->ordem = $row['ordem'];
            $etapa->acao = $row['acao'];
            $etapa->tempo_execucao = $row['tempo_execucao'];
            $etapa->digitar = $row['digitar'];
            $etapa->caminho = $row['caminho'];
            $etapa->atalho = $row['atalho'];

            $etapa->save();
        }

        return 'ok';
    }
}
