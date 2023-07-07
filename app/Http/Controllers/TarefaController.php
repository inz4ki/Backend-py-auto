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
        $Dia = Carbon::now()->translatedFormat('d');
        $DiaTeste = Carbon::now()->translatedFormat('d/m/Y');
        $ultimoDia = Carbon::now()->endOfMonth()->translatedFormat('d');

        #teste
        $trimestal = Carbon::createFromFormat('d/m/Y', $DiaTeste)->isoFormat('DD/MM/YYYY');

        $consultarMensal = Tarefa::where('dia_da_semana', 'LIKE', "%Mensal,{$Dia}%")
            ->where('hora_executar', '<', $horaAtual)
            ->where('estado', '=', 'não executado')
            ->get();

        $consultarUltimoDia = Tarefa::where('dia_da_semana', 'LIKE', "%Ultimo%")
            ->where('hora_executar', '<', $horaAtual)
            ->where('estado', '=', 'não executado')
            ->orderBy('hora_executar')
            ->first();

        $consultarMensalDia = Tarefa::where('hora_executar', '<', $horaAtual)
            ->where('dia_da_semana', 'LIKE', "%{$Dia}%")
            ->where('estado', '=', 'não executado')
            ->orderBy('hora_executar')
            ->first();

        $ConsultarSemanal = Tarefa::where('hora_executar', '<', $horaAtual)
            ->where('estado', '=', 'não executado')
            ->where('dia_da_semana', 'LIKE', "%{$nomeDia}%")
            ->orderBy('hora_executar')
            ->first();

        $ConsultarTrimestral = Tarefa::where('hora_executar', '<', $horaAtual)
            ->where('estado', '=', 'não executado')
            ->where('dia_da_semana', 'LIKE', "%{$trimestal}%")
            ->orderBy('hora_executar')
            ->first();

        $executando = Tarefa::where('estado', '=', 'executando')->get();

        if (!$executando->isEmpty()) {
            echo $executando;
        } else {
            if (!$consultarMensal->isEmpty()) {
                echo $consultarMensalDia;
            } else if ($Dia === $ultimoDia && $consultarUltimoDia == true) {
                echo $consultarUltimoDia;
            } else if ($ConsultarTrimestral == true) {
                echo $ConsultarTrimestral;
                $update = Carbon::now()->addMonths(3)->translatedFormat('d/m/Y');
                $updateTrimestral = $ConsultarTrimestral;
                $updateTrimestral ->update([
                    'dia_da_semana' => $update
                ]);
            } else {
                echo $ConsultarSemanal;
            }
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
