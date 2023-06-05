<?php

namespace App\Http\Controllers;
use App\Models\User;
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
