<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Support\Facades\Session;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $usuario = Usuario::where(['usuario' => $username, 'contrasenia' => $password])->first();

            if (!$usuario) {
                throw new Exception("Datos de acceso incorrectos.", 1);
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
