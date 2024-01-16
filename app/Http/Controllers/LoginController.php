<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Candidato;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'cpf' => 'required',
            'senha' => 'required',
        ]);

        $senha = md5($request->senha);

        $usuario = User::where('cpf', $request->cpf)
            ->where('senha', $senha)
            ->where('acesso_plataforma', "LIKE","%bot%")
            ->first();

        if ($usuario) {
            $token = $usuario->createToken('_usuario_token');
            return  response()->json([
                '_usuario_token' => $token->plainTextToken,
                'id' => $usuario->pk_id_usuario
            ]);
        }

        return response('Credenciais invalidas', 401);
    
    }

#CANDIDATO RHSTV
    public function loginCandidato(Request $request)
    {
        $request->validate([
            'cpf' => 'required',
            'senha' => 'required',
        ]);

        $senha = md5($request->senha);

        $candidato = Candidato::where('cpf', $request->cpf)
            ->where('senha', $senha)
            ->first();

        if ($candidato) {
            $token = $candidato->createToken('_candidato_token');
            return  response()->json([
                '_candidato_token' => $token->plainTextToken,
                'pk_id_candidato' => $candidato->pk_id_candidato
            ]);
        }

        return response('Credenciais invalidas', 401);
    }
    
    public function loginRecrutador(Request $request)
    {
        $request->validate([
            'cpf' => 'required',
            'senha' => 'required',
        ]);

        $senha = md5($request->senha);

        $usuario = User::where('cpf', $request->cpf)
            ->where('senha', $senha)
            ->where('acesso_plataforma', "LIKE","%rh%")
            ->first();

        if ($usuario) {
            $token = $usuario->createToken('_usuario_token');
            return  response()->json([
                '_usuario_token' => $token->plainTextToken,
                'id' => $usuario->pk_id_usuario
            ]);
        }

        return response('Credenciais invalidas', 401);
    
    }
    
}
