<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use Exception;

use Illuminate\Http\Request;
use App\Models\Usuario;

class SigninController extends Controller
{
    public function signin()
    {
        return view('login.signin');
    }

    public function login(Request $request)
    {
        try {
            $username = $request->input('username');
            $password = $request->input('password');

            $usuario = Usuario::where(['usuario' => $username])->first();

            if (!$usuario) {
                throw new Exception("Usuario incorrecto.", 1);
            }

            if (!(Hash::check($password, $usuario->contrasenia))) {
                throw new Exception("Contraseña incorrecta.", 1);
            }

            $rol = Rol::find($usuario->rol_id);

            Session::put([
                'usuario' => $usuario,
                'rol' => $rol
            ]);

            return response()->json($usuario, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/signin');
    }
}
