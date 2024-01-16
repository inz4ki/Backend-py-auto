<?php

use App\Http\Controllers\EtapaController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ObstaculoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaHorarioController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


#Python rotas
Route::get('tarefas/executar', [TarefaController::class, 'pesquisarTarefasParaExecutar'])->name('tarefas.pesquisarTarefasParaExecutar');
Route::post('editar/etapa/{etapa}', [EtapaController::class, 'updateById'])->name('etapa.updateById');
Route::patch('tarefa/reiniciar', [TarefaController::class, 'reiniciarCampoEstado'])->name('tarefa.reiniciarCampoEstado');
Route::put('tarefa/editar/{tarefa}', [TarefaController::class, 'update'])->name('tarefa.update');

Route::get('etapas/{tarefa}', [EtapaController::class, 'showAll'])->name('etapa.showAll');
Route::put('editar/etapas', [EtapaController::class, 'update'])->name('etapa.update');
#Tarefas rotas
Route::get('tarefas', [TarefaController::class, 'showAll'])->name('tarefas.showAll');
Route::get('tarefa/{tarefa}', [TarefaController::class, 'show'])->name('tarefa.show'); 
#log rotas
Route::post('log/salvar', [LogController::class, 'store'])->name('log.store');
Route::get('log', [LogController::class, 'showAll'])->name('log.showAll');
Route::get('log/tarefa/{tarefa}', [LogController::class, 'show'])->name('log.show'); 
Route::get('log/tarefa/dias/{tarefa}', [LogController::class, 'show30Days'])->name('log.show30Days'); 

#Usuarios rotas
Route::get('usuarios', [UserController::class, 'listarTodosUsuarios'])->name('usuarios.listarTodosUsuarios');
Route::get('usuario/{usuario}', [UserController::class, 'listarUsuario'])->name('usuarios.listarUsuario');
Route::post('usuarios/guardar', [UserController::class, 'guardarUsuario'])->name('usuarios.guardarUsuario');
Route::post('usuarios/login', [LoginController::class, 'login'])->name('login');

#TarefaHorario
Route::get('TarefaHorario/showall', [TarefaHorarioController::class, 'showAll'])->name('tarefa.showAll');
Route::get('TarefaHorario/show/{tarefaHorario}', [TarefaHorarioController::class, 'show'])->name('tarefa.show');
Route::post('TarefaHorario/salvar', [TarefaHorarioController::class, 'store'])->name('tarefa.store');

#obstaculo
Route::post('tarefa/obstaculo/salvar', [ObstaculoController::class, 'store'])->name('obstaculo.store');
Route::get('tarefa/obstaculo/{tarefa}', [ObstaculoController::class, 'showAll'])->name('obstaculo.showAll');

#TESTES
// Route::get('teste', [TarefaController::class, 'teste'])->name('tarefa.teste');
// Route::put('teste/editar/{tarefa}', [TarefaController::class, 'updateTeste'])->name('tarefa.updateTeste');
// Route::put('teste/reiniciar', [TarefaController::class, 'testeReiniciar'])->name('tarefa.testeReiniciar');
// Route::patch('teste/reiniciar/{tarefa}', [TarefaController::class, 'testereiniciarCampoEstadoComID'])->name('tarefa.testereiniciarCampoEstadoComID');
// Route::patch('teste/desativar/{tarefa}', [TarefaController::class, 'testedesativarCampoEstadoComID'])->name('tarefa.testedesativarCampoEstadoComID');


Route::group(['middleware' => ['auth:sanctum']], function () {
    
    #etapas com segurança rotas
    Route::post('etapa/salvar', [EtapaController::class, 'store'])->name('etapa.store');
    Route::delete('etapa/{etapa}', [EtapaController::class, 'destroy'])->name('etapa.destroy');
    Route::get('etapa/{etapa}', [EtapaController::class, 'showTask'])->name('etapa.showTask');    
    #Tarefas rotas
    Route::post('tarefa/salvar', [TarefaController::class, 'store'])->name('tarefa.store');
    Route::delete('tarefa/{tarefa}', [TarefaController::class, 'destroy'])->name('tarefa.destroy');
    Route::put('tarefa/atualizar/{tarefa}', [TarefaController::class, 'atualizarTarefa'])->name('tarefa.atualizarTarefa');
    Route::post('tarefa/clonar/{tarefa}', [TarefaController::class, 'duplicate'])->name('tarefa.duplicate');
    Route::patch('tarefa/reiniciar/{tarefa}', [TarefaController::class, 'reiniciarCampoEstadoComID'])->name('tarefa.reiniciarCampoEstadoComID');
    Route::patch('tarefa/desativar/{tarefa}', [TarefaController::class, 'desativarCampoEstadoComID'])->name('tarefa.desativarCampoEstadoComID');
    #TarefaHorarios rotas
    Route::delete('TarefaHorario/{tarefaHorario}', [TarefaHorarioController::class, 'destroy'])->name('tarefa.destroy');   
});


# SITE RH TOTALMENTE SEPARADO
//vagas
Route::get('vagas', [VagasController::class, 'listarVagas'])->name('vagas.listarVagas');


Route::get('vagas/{vaga}', [VagasController::class, 'listarVaga'])->name('vagas.listarVaga');

//usuario rotas de usuario estao replicadas                                      
// Route::get('usuarios', [UserController::class, 'listarTodosUsuarios'])->name('usuarios.listarTodosUsuarios');
// Route::put('usuarios/{usuario}', [UserController::class, 'editarUsuario'])->name('usuario.editarUsuario');
// Route::delete('usuarios/{usuario}', [UserController::class, 'deletarUsuario'])->name('usuario.deletarUsuario');
// Route::get('usuarios/{usuario}', [UserController::class, 'listarUsuario'])->name('usuario.listarUsuario');
// Route::post('usuarios/guardar', [UserController::class, 'guardarUsuario'])->name('usuarios.guardarUsuario');
// Route::post('usuarios/login', [UserController::class, 'login'])->name('usuarios.login');

//Candidatos
Route::get('candidato', [CandidatoController::class, 'listarCandidatos'])->name('candidato.listarCandidatos');
Route::post('candidato/salvar', [CandidatoController::class, 'salvarCandidato'])->name('candidato.salvarCandidato');
Route::put('candidato/{candidato}', [CandidatoController::class, 'editarCandidato'])->name('candidato.editarCandidato');
Route::put('candidato/senha/{candidato}', [CandidatoController::class, 'editarSenha'])->name('candidato.editarSenha');
Route::delete('candidato/{candidato}', [CandidatoController::class, 'deletarCandidato'])->name('candidato.deletarCandidato');
Route::get('candidato/{candidato}', [CandidatoController::class, 'listarCandidato'])->name('candidato.listarCandidato');



//Formaçao
Route::get('formacao', [FormacaoController::class, 'listarFormacoes'])->name('formacao.listarFormacoes');
Route::post('formacao/salvar', [FormacaoController::class, 'salvarFormacao'])->name('formacao.salvarFormacao');
Route::put('formacao/{formacao}', [FormacaoController::class, 'editarFormacao'])->name('formacao.editarFormacao');
Route::delete('formacao/{formacao}', [FormacaoController::class, 'deletarFormacao'])->name('formacao.deletarFormacao');
Route::get('formacao/{formacao}', [FormacaoController::class, 'listarFormacao'])->name('formacao.listarFormacao');

//curso
Route::post('curso/salvar', [CursoController::class, 'salvarCurso'])->name('curso.salvarCurso');
Route::put('curso/{curso}', [CursoController::class, 'editarCurso'])->name('curso.editarCurso');
Route::delete('curso/{curso}', [CursoController::class, 'deletarCurso'])->name('curso.deletarCurso');
Route::get('curso/{curso}', [CursoController::class, 'listarCurso'])->name('curso.listarCurso');

//Experiencia
Route::post('experiencia/salvar', [ExperienciaController::class, 'salvarExperiencia'])->name('experiencia.salvarExperiencia');
Route::put('experiencia/{experiencia}', [ExperienciaController::class, 'editarExperiencia'])->name('experiencia.editarExperiencia');
Route::delete('experiencia/{experiencia}', [ExperienciaController::class, 'deletarExperiencia'])->name('experiencia.deletarExperiencia');
Route::get('experiencia/{experiencia}', [ExperienciaController::class, 'listarExperiencia'])->name('experiencia.listarExperiencia');

//Route::post('usuarios/login', [LoginController::class, 'loginRecrutador'])->name('loginRecrutador');
Route::post('candidato/login', [LoginController::class, 'loginCandidato'])->name('login.loginCandidato');
Route::post('recrutador/login', [LoginController::class, 'loginRecrutador'])->name('login.loginRecrutador');

//Processos seletivos
Route::get('candidato/listar_vagas/{candidato}', [ProcessoSeletivoController::class, 'acharVagasCandidato'])->name('processoSeletivo.acharVagasCandidato');
Route::get('usuario/listar_candidatos/{vagas}', [ProcessoSeletivoController::class, 'acharCandidatosVaga'])->name('processoSeletivo.acharCandidatosVaga');
Route::post('processo/salvar', [ProcessoSeletivoController::class, 'salvarProcessoSeletivo'])->name('processoSeletivo.salvarProcessoSeletivo');

Route::group(['middleware' => ['auth:sanctum']], function () {
// Route::post('usuarios/logout', [UserController::class, 'logout'])->name('usuario.logout');
Route::post('vagas/salvar', [VagasController::class, 'salvarVaga'])->name('vaga.salvarVaga');
Route::put('vagas/{vagas}', [VagasController::class, 'editarVagas'])->name('vagas.editarVagas');
Route::delete('vagas/{vaga}', [VagasController::class, 'deletarVaga'])->name('vagas.deletarVaga');
});


//pdf
Route::post('candidato/pdf', [PdfController::class, 'upload'])->name('pdf.upload');
Route::get('candidato/download_pdf/{arquivo}', [PdfController::class, 'download'])->name('pdf.download');
