<?php

namespace App\Http\Controllers;

use App\Models\Obstaculo;
use Illuminate\Http\Request;
use App\Models\Tarefa;

class ObstaculoController extends Controller
{
    public function store(Request $request)
    {
        $obstaculo = new Obstaculo();
        $obstaculo->fk_id_tarefa = $request->fk_id_tarefa;
        $obstaculo->obstaculo = $request->file('obstaculo')->store('/obstaculo','public');
        $obstaculo->acao = $request->file('acao')->store('/obstaculo','public');
        $obstaculo->save();

        return $obstaculo;
    }

    public function showAll(Tarefa $tarefa)
    {
        $fk_id_tarefa = $tarefa->pk_id_tarefa;

        $consultaObstaculo = Obstaculo::where('bot_obstaculo.fk_id_tarefa', '=', $fk_id_tarefa)
            ->select('bot_obstaculo.*')
            ->get();

        return $consultaObstaculo;
    }


}
