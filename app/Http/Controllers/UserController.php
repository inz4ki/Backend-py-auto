<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function listarTodosUsuarios()
    {
        $usuarios = User::all();
        //Retorna em Json
        return $usuarios;
    }


    // Lista visualmente os um usuario especifico
    public function listarUsuario(User $usuario)
    {
        return $usuario;
        // Lista visualmente os um usuario especifico
        //        return view('listUser', [
        //            'usuario' => $usuario
        //        ]);
    }


    // metodo que grava o usuario no banco
    public function guardarUsuario(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
         ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = md5($request->password);
        $usuario->save();

        return $usuario;
    }

    //Edita um usuario ja criado
    public function editarUsuario(User $usuario, Request $request)
    {
        $usuario->nome = $request->nome;


        $usuario->email = $request->email;


        if (!empty($request->password)) {
            $usuario->password = md5($request->password);
        }

        $usuario->save();
        return "ok";
    }

    // Deleta o usuario
    public function deletarUsuario(User $usuario)
    {
        $usuario->delete();
        //return redirect()->route('users.listAll');
        return "ok";
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status_code' => 200,
            'message' => 'Token deleted'
        ]);
    }
}
