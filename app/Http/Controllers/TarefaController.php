<?php

namespace App\Http\Controllers;

use App\Models\Etapa;
use Illuminate\Http\Request;
use App\Models\Tarefa;
use Carbon\Carbon;
use DateTime;

use App\Models\TarefaHorario;

class TarefaController extends Controller
{

    public function store(Request $request)
    {
        $tarefa = new Tarefa();
        $tarefa->nome_tarefa = $request->nome_tarefa;
        $tarefa->dia_da_semana = $request->dia_da_semana;
        // $tarefa->estado = $request->estado;
        // $tarefa->hora_executar = $request->hora_executar;
        $tarefa->equipe = $request->equipe;
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

    public function update(Request $request, TarefaHorario $tarefa)
    {
        $tarefa->estado = $request->estado;
        $tarefa->save();

        return 'ok';
    }

    public function atualizarTarefa(Request $request, Tarefa $tarefa)
    {
        if ($tarefa->dia_da_semana === "Tarefa Filha") {
            $tarefa->dia_da_semana = $request->dia_da_semana;
            $tarefa->hora_executar = $request->hora_executar;
            $tarefa->nome_tarefa = $request->nome_tarefa;
            $tarefa->estado = 'Desativado';
            $tarefa->equipe = $request->equipe;
            $tarefa->save();

            return $request;
        } else {
            $tarefa->dia_da_semana = $request->dia_da_semana;
            $tarefa->nome_tarefa = $request->nome_tarefa;
            // $tarefa->estado = $request->estado;
            // $tarefa->hora_executar = $request->hora_executar;
            $tarefa->equipe = $request->equipe;
            $tarefa->save();

            return $request;
        }
    }

    public function reiniciarCampoEstado()
    {
        // $tarefa = Tarefa::where('estado', '!=', 'não executado')
        //     ->where('estado', '!=', 'Desativado')
        //     ->where('dia_da_semana', '!=', 'Tarefa Filha')
        //     ->update(['estado' => 'não executado']);

        // $tarefaFilha = Tarefa::where('estado', '!=', 'não executado')
        //     ->where('dia_da_semana', '=', 'Tarefa Filha')
        //     ->update(['estado' => 'Desativado']);

        // return $tarefa;

        $tarefa = TarefaHorario::where('estado', '!=', 'não executado')
            ->where('estado', '!=', 'Desativado')
            ->update(['estado' => 'não executado']);

        return $tarefa;
    }

    public function reiniciarCampoEstadoComID(Request $request)
    {
        // $tarefaID = $request->tarefa;
        // $tarefa = Tarefa::where('pk_id_tarefa', '=', $tarefaID)
        //     ->update(['estado' => 'não executado']);
        // return $tarefa;
        $tarefaID = $request->tarefa;
        $tarefa = TarefaHorario::where('pk_id_horario_tarefas', '=', $tarefaID)
            ->update(['estado' => 'não executado']);
        echo $tarefa;
    }
    public function desativarCampoEstadoComID(Request $request)
    {
        $tarefaID = $request->tarefa;
        $tarefa = TarefaHorario::where('pk_id_horario_tarefas', '=', $tarefaID)
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
        $trimestal = Carbon::createFromFormat('d/m/Y', $DiaTeste)->isoFormat('DD/MM/YYYY');


        // $consultarMensal = Tarefa::where('dia_da_semana', 'LIKE', "%Mensal,{$Dia}%")
        //     ->where('hora_executar', '<', $horaAtual)
        //     ->where('estado', '=', 'não executado')
        //     ->get();

        // $consultarUltimoDia = Tarefa::where('dia_da_semana', 'LIKE', "%Ultimo%")
        //     ->where('hora_executar', '<', $horaAtual)
        //     ->where('estado', '=', 'não executado')
        //     ->orderBy('hora_executar')
        //     ->first();

        // $consultarMensalDia = Tarefa::where('hora_executar', '<', $horaAtual)
        //     ->where('dia_da_semana', 'LIKE', "%{$Dia}%")
        //     ->where('estado', '=', 'não executado')
        //     ->orderBy('hora_executar')
        //     ->first();

        // $ConsultarSemanal = Tarefa::where('hora_executar', '<', $horaAtual)
        //     ->where('estado', '=', 'não executado')
        //     ->where('dia_da_semana', 'LIKE', "%{$nomeDia}%")
        //     ->orderBy('hora_executar')
        //     ->first();

        // $ConsultarTrimestral = Tarefa::where('hora_executar', '<', $horaAtual)
        //     ->where('estado', '=', 'não executado')
        //     ->where('dia_da_semana', 'LIKE', "%{$trimestal}%")
        //     ->orderBy('hora_executar')
        //     ->first();

        // $ConsultarTarefaFilha = Tarefa::where('estado', '=', 'não executado')
        //     ->where('dia_da_semana', 'LIKE', "Tarefa Filha")
        //     ->orderBy('hora_executar')
        //     ->first();



        // $executando = Tarefa::where('estado', '=', 'executando')->get();

        // if (!$executando->isEmpty()) {
        //     echo $executando;
        // } else {
        //     if (!$consultarMensal->isEmpty()) {
        //         echo $consultarMensalDia;
        //     } else if ($Dia === $ultimoDia && $consultarUltimoDia == true) {
        //         echo $consultarUltimoDia;
        //     } else if ($ConsultarTrimestral == true) {
        //         echo $ConsultarTrimestral;
        //         $update = Carbon::now()->addMonths(3)->translatedFormat('d/m/Y');
        //         $updateTrimestral = $ConsultarTrimestral;
        //         $updateTrimestral->update([
        //             'dia_da_semana' => $update
        //         ]);
        //     } else if ($ConsultarTarefaFilha == true) {
        //         $ConsultarTarefaFilha->update([
        //             'estado' => 'não executado'
        //         ]);
        //         echo $ConsultarTarefaFilha;
        //     } else {
        //         echo $ConsultarSemanal;
        //     }
        // }

        $testeSemanal = Tarefa::where('dia_da_semana', 'LIKE', "%{$nomeDia}%")
            ->select('pk_id_tarefa')
            ->get();
        $testeMensal = Tarefa::where('dia_da_semana', 'LIKE', "%Mensal,{$Dia}")->get();
        $testeUltimoDia = Tarefa::where('dia_da_semana', 'LIKE', "%Ultimo%")->get();
        $testeTrimestral = Tarefa::where('dia_da_semana', 'LIKE', "%{$trimestal}%")->get();
        $testeTarefaFilha = Tarefa::where('dia_da_semana', 'LIKE', "Tarefa Filha")->get();
        $executando = TarefaHorario::where('estado', '=', 'executando')->get();
        // FUNCIONAL
        if (!$executando->isEmpty()) {
            echo $executando;
        } else {
            // FUNCIONAL
            if (!$testeMensal->isEmpty()) {
                $primeiroHorario = $testeMensal->first();
                $testePesquisaMensal = TarefaHorario::where('fk_id_tarefa_horarios', '=', $primeiroHorario->pk_id_tarefa)
                    ->where('hora_executar', '<', $horaAtual)
                    ->where('estado', '=', 'não executado')
                    ->orderBy('hora_executar')
                    ->first();
                if ($testeMensal !== null && $testePesquisaMensal !== null) {
                    echo $testePesquisaMensal;
                }
            }
            // FUNCIONAL
            else if (!$testeUltimoDia->isEmpty()) {
                $primeiroHorario = $testeUltimoDia->first();
                $testeUltimoDia = TarefaHorario::where('fk_id_tarefa_horarios', '=', $primeiroHorario->pk_id_tarefa)
                    ->where('hora_executar', '<', $horaAtual)
                    ->where('estado', '=', 'não executado')
                    ->orderBy('hora_executar')
                    ->first();
                if ($Dia === $ultimoDia && $testeUltimoDia !== null) {
                    echo $testeUltimoDia;
                }
            }
            // FUNCIONAL
            else if (!$testeTrimestral->isEmpty()) {
                $primeiroHorario = $testeTrimestral->first();
                $testePesquisaTrimestral = TarefaHorario::where('fk_id_tarefa_horarios', '=', $primeiroHorario->pk_id_tarefa)
                    ->where('hora_executar', '<', $horaAtual)
                    ->where('estado', '=', 'não executado')
                    ->orderBy('hora_executar')
                    ->first();
                if ($testeTrimestral !== null && $testePesquisaTrimestral !== null) {
                    echo $testePesquisaTrimestral;
                    $update = Carbon::now()->addMonths(3)->translatedFormat('d/m/Y');
                    $updateTrimestral = $primeiroHorario;
                    $updateTrimestral->update([
                        'dia_da_semana' => $update
                    ]);
                }
                // FUNCIONAL
            } else if (!$testeTarefaFilha->isEmpty()) {
                $primeiroHorario = $testeTarefaFilha->first();
                $primeiroHorario->update([
                    'estado' => 'não executado'
                ]);
                $testePesquisaTarefaFilha = TarefaHorario::where('fk_id_tarefa_horarios', '=', $primeiroHorario->pk_id_tarefa)
                    ->where('hora_executar', '<', $horaAtual)
                    ->where('estado', '=', 'não executado')
                    ->orderBy('hora_executar')
                    ->first();
                if ($testeTarefaFilha !== null && $testePesquisaTarefaFilha !== null) {
                    echo $testePesquisaTarefaFilha;
                }
                // FUNCIONAL
            } else {
                if (!$testeSemanal->isEmpty()) {
                    foreach ($testeSemanal as $row) { 
                        $pesquisar = $row->pk_id_tarefa;
                        $testePesquisaSemanal = TarefaHorario::where('hora_executar', '<', $horaAtual)
                            ->where('estado', '=', 'não executado')
                            ->where('fk_id_tarefa_horarios', '=', $pesquisar)
                            ->orderBy('hora_executar')
                            ->first();
                        if($testePesquisaSemanal != null){
                            break;
                        } 
                    }
                    return $testePesquisaSemanal;
                }
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
        $tarefa->equipe = $request->equipe;
        $tarefa->save();

        $cloneTarefaId = $tarefa->pk_id_tarefa;

        $etapaSalvar = Etapa::where('bot_etapas.fk_id_tarefa_etapa', '=', $tarefaId)
            ->get();

        foreach ($etapaSalvar as $row) {
            $etapa = new Etapa();
            $etapa->nome_etapa = $row['nome_etapa'];
            $etapa->fk_id_tarefa_etapa = $cloneTarefaId;
            $etapa->ordem = $row['ordem'];
            $etapa->acao = $row['acao'];
            $etapa->tempo_execucao = $row['tempo_execucao'];
            $etapa->digitar = $row['digitar'];
            $etapa->caminho = $row['caminho'];
            $etapa->atalho = $row['atalho'];
            $etapa->renomear_data = $row['renomear_data'];

            $etapa->save();
        }

        return 'ok';
    }



    //FUNCIONAIS
    // public function teste()
    // {
    //     Carbon::setLocale('pt');
    //     $horaAtual = Carbon::now();
    //     $nomeDia = Carbon::now()->translatedFormat('D');
    //     $Dia = Carbon::now()->translatedFormat('d');
    //     $DiaTeste = Carbon::now()->translatedFormat('d/m/Y');
    //     $ultimoDia = Carbon::now()->endOfMonth()->translatedFormat('d');
    //     $trimestal = Carbon::createFromFormat('d/m/Y', $DiaTeste)->isoFormat('DD/MM/YYYY');



    //     //TESTE DE MUDANÇA FORMA PESQUISA

    //     $testeSemanal = Tarefa::where('dia_da_semana', 'LIKE', "%{$nomeDia}%")->get();
    //     $testeMensal = Tarefa::where('dia_da_semana', 'LIKE', "%Mensal,{$Dia}")->get();
    //     $testeUltimoDia = Tarefa::where('dia_da_semana', 'LIKE', "%Ultimo%")->get();
    //     $testeTrimestral = Tarefa::where('dia_da_semana', 'LIKE', "%{$trimestal}%")->get();
    //     $testeTarefaFilha = Tarefa::where('dia_da_semana', 'LIKE', "Tarefa Filha")->get();
    //     $executando = TarefaHorario::where('estado', '=', 'executando')->get();
    //     // FUNCIONAL
    //     if (!$executando->isEmpty()) {
    //         echo $executando;
    //     } else {
    //         // FUNCIONAL
    //         if (!$testeMensal->isEmpty()) {
    //             $primeiroHorario = $testeMensal->first();
    //             $testePesquisaMensal = TarefaHorario::where('fk_id_tarefa_horarios', '=', $primeiroHorario->pk_id_tarefa)
    //                 ->where('hora_executar', '<', $horaAtual)
    //                 ->where('estado', '=', 'não executado')
    //                 ->orderBy('hora_executar')
    //                 ->first();
    //             if ($testeMensal !== null && $testePesquisaMensal !== null) {
    //                 echo $testePesquisaMensal;
    //             }
    //         }
    //         // FUNCIONAL
    //         else if (!$testeUltimoDia->isEmpty()) {
    //             $primeiroHorario = $testeUltimoDia->first();
    //             $testeUltimoDia = TarefaHorario::where('fk_id_tarefa_horarios', '=', $primeiroHorario->pk_id_tarefa)
    //                 ->where('hora_executar', '<', $horaAtual)
    //                 ->where('estado', '=', 'não executado')
    //                 ->orderBy('hora_executar')
    //                 ->first();
    //             if ($Dia === $ultimoDia && $testeUltimoDia !== null) {
    //                 echo $testeUltimoDia;
    //             }
    //         }
    //         // FUNCIONAL
    //         else if (!$testeTrimestral->isEmpty()) {
    //             $primeiroHorario = $testeTrimestral->first();
    //             $testePesquisaTrimestral = TarefaHorario::where('fk_id_tarefa_horarios', '=', $primeiroHorario->pk_id_tarefa)
    //                 ->where('hora_executar', '<', $horaAtual)
    //                 ->where('estado', '=', 'não executado')
    //                 ->orderBy('hora_executar')
    //                 ->first();
    //             if ($testeTrimestral !== null && $testePesquisaTrimestral !== null) {
    //                 echo $testePesquisaTrimestral;
    //                 $update = Carbon::now()->addMonths(3)->translatedFormat('d/m/Y');
    //                 $updateTrimestral = $primeiroHorario;
    //                 $updateTrimestral->update([
    //                     'dia_da_semana' => $update
    //                 ]);
    //             }
    //             // FUNCIONAL
    //         } else if (!$testeTarefaFilha->isEmpty()) {
    //             $primeiroHorario = $testeTarefaFilha->first();
    //             $primeiroHorario->update([
    //                 'estado' => 'não executado'
    //             ]);
    //             $testePesquisaTarefaFilha = TarefaHorario::where('fk_id_tarefa_horarios', '=', $primeiroHorario->pk_id_tarefa)
    //                 ->where('hora_executar', '<', $horaAtual)
    //                 ->where('estado', '=', 'não executado')
    //                 ->orderBy('hora_executar')
    //                 ->first();
    //             if ($testeTarefaFilha !== null && $testePesquisaTarefaFilha !== null) {
    //                 echo $testePesquisaTarefaFilha;
    //             }
    //             // FUNCIONAL
    //         } else {
    //             if ($testeSemanal !== null) {
    //                 $testePesquisaSemanal = TarefaHorario::where('hora_executar', '<', $horaAtual)
    //                     ->where('estado', '=', 'não executado')
    //                     ->orderBy('hora_executar')
    //                     ->first();
    //                 return $testePesquisaSemanal;
    //             }
    //         }
    //     }
    // }
    // public function updateTeste(Request $request, TarefaHorario $tarefa)
    // {
    //     $tarefa->estado = $request->estado;
    //     $tarefa->save();

    //     return 'ok';
    // }
    // public function testeReiniciar()
    // {
    //     $tarefa = TarefaHorario::where('estado', '!=', 'não executado')
    //         ->where('estado', '!=', 'Desativado')
    //         ->update(['estado' => 'não executado']);

    //     return $tarefa;
    // }

    // public function testereiniciarCampoEstadoComID(Request $request)
    // {
    //     $tarefaID = $request->tarefa;
    //     $tarefa = TarefaHorario::where('pk_id_horario_tarefas', '=', $tarefaID)
    //         ->update(['estado' => 'não executado']);
    //         echo $tarefa;
    // }

    // public function testedesativarCampoEstadoComID(Request $request)
    // {
    //     $tarefaID = $request->tarefa;
    //     $tarefa = TarefaHorario::where('pk_id_horario_tarefas', '=', $tarefaID)
    //         ->update(['estado' => 'Desativado']);
    //     return $tarefa;
    // }
}
