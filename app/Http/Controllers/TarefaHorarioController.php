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

    public function show(TarefaHorario $tarefaHorario)
    {
        return $tarefaHorario;
    }

    public function store(Request $request)
    {
        $tarefaHorario = new TarefaHorario();
        $tarefaHorario->fk_id_tarefa = $request->fk_id_tarefa;
        $tarefaHorario->data_hora_executar = $request->data_hora_executar;
        $tarefaHorario->dia_da_semana = $request->dia_da_semana;
        $tarefaHorario->estado = $request->estado;
        $tarefaHorario->save();

        return $tarefaHorario;
    }

    public function update(Request $request, TarefaHorario $tarefaHorario)
    {
        $tarefaHorario->fk_id_tarefa = $request->fk_id_tarefa;
        $tarefaHorario->data_hora_executar = $request->data_hora_executar;
        $tarefaHorario->dia_da_semana = $request->dia_da_semana;
        $tarefaHorario->estado = $request->estado;
        $tarefaHorario->save();

        return $tarefaHorario;
    }

    public function destroy(TarefaHorario $tarefaHorario)
    {
        $tarefaHorario->delete();
        return 'deletado com sucesso';
    }
}
