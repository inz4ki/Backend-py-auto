<?php

namespace App\Http\Controllers;

use App\Models\TarefaHorario;
use Illuminate\Http\Request;

##IMPLEMENTAR FUTURAMENTE
class TarefaHorarioController extends Controller
{

    public function showAll()
    {
        $tarefaHorario = TarefaHorario::all();

        return $tarefaHorario;
    }

    public function show(Request $request)
    {
        $tarefaID = $request->tarefaHorario;
        $tarefa = TarefaHorario::where('fk_id_tarefa_horarios', '=', $tarefaID)->get();
        return $tarefa;
    }

    public function store(Request $request)
    {
        $tarefaHorario = new TarefaHorario();
        $tarefaHorario->fk_id_tarefa_horarios = $request->fk_id_tarefa_horarios;
        $tarefaHorario->hora_executar = $request->hora_executar;
        $tarefaHorario->estado = 'não executado';
        $tarefaHorario->save();

        return $tarefaHorario;
    }

    public function update(Request $request, TarefaHorario $tarefaHorario)
    {
        $tarefaHorario->fk_id_tarefa_horarios = $request->fk_id_tarefa_horarios;
        $tarefaHorario->hora_executar = $request->hora_executar;
        $tarefaHorario->estado = $request->estado;
        $tarefaHorario->save();

        return $tarefaHorario;
    }

    public function destroy(TarefaHorario $tarefaHorario)
    {
        $tarefaHorario->delete();
        return $tarefaHorario;
    }
}
