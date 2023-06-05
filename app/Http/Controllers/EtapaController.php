<?php

namespace App\Http\Controllers;

use App\Models\Etapa;
use App\Models\Tarefa;
use Illuminate\Http\Request;

class EtapaController extends Controller
{

    public function store(Request $request)
    {
        $etapa = new Etapa();
        $etapa->fk_id_tarefa = $request->fk_id_tarefa;
        $etapa->ordem = $request->ordem;
        $etapa->nome_etapa = $request->nome_etapa;
        $etapa->acao = $request->acao;
        $etapa->tempo_execucao = $request->tempo_execucao;
        $etapa->digitar = $request->digitar;
        $etapa->atalho = $request->atalho;
        $etapa->caminho = $request->file('imagem')->store('/', 'public');

        $etapa->save();

        return $etapa;
    }

    public function showAll(Tarefa $tarefa)
    {
        $tarefaID = $tarefa->pk_id_tarefa;

        $consultaEtapa = Etapa::where('bot_etapas.fk_id_tarefa', '=', $tarefaID)
            ->select('bot_etapas.*')
            ->orderBy('bot_etapas.ordem')
            ->get();

        return $consultaEtapa;
    }

    public function showTask(Etapa $etapa)
    {
        return $etapa;
    }


    public function update(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        foreach ($data as $value) {          
            $etapa = Etapa::find($value['pk_id_etapa']);
            $etapa->ordem = $value['ordem'];
            $etapa->save(); 
        }
    }

    public function updateById(Etapa $etapa ,Request $request)
    {
        $etapa->nome_etapa = $request->nome_etapa;
        $etapa->acao = $request->acao;
        $etapa->tempo_execucao = $request->tempo_execucao;
        $etapa->digitar = $request->digitar;
        $etapa->caminho = $request->file('imagem')->store('/', 'public');
        $etapa->atalho = $request->atalho;
        $etapa->save();


        return $etapa;
    }


    public function destroy(Etapa $etapa)
    {
        $etapa->delete();
        return 'deletado com sucesso';
    }
}
