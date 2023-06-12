<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UsuarioController extends Controller
{
    public function lista()
    {
        $usuarios = Usuario::with('rol')->get();
        $roles = Rol::all();

        $data = [
            'usuarios' => $usuarios,
            'roles' => $roles
        ];

        return view('content.usuarios.lista', $data);
    }

    public function agregar(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuarioData = $request->all();
            $usuarioData['contrasenia'] = Hash::make($usuarioData['contrasenia']);
            $usuario = Usuario::where('dni', $usuarioData['dni'])
                ->orWhere('usuario', $usuarioData['usuario'])
                ->first();


            if ($usuario) {
                throw new Exception("Ya existe un usuario con esos datos", 1);
            }

            $newUsuario = new Usuario();
            $newUsuario->fill($usuarioData);
            $newUsuario->save();

            DB::commit();
            return response()->json('Usuario registrado correctamente.', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage(), 500);
        }
    }

    public function buscar(Request $request)
    {
        $id = $request->input('id');
        $usuario = Usuario::find($id);
        return response()->json($usuario, 200);
    }

    public function editar(Request $request)
    {
        DB::beginTransaction();

        try {
            $usuarioData = $request->all();

            if (array_key_exists('contrasenia', $usuarioData)) {
                $usuarioData['contrasenia'] = Hash::make($usuarioData['contrasenia']);
            }

            $existUsuario = Usuario::where(function ($query) use ($usuarioData) {
                $query->where('dni', $usuarioData['dni'])
                    ->orWhere('usuario', $usuarioData['usuario']);
            })->whereNotIn('id', [$usuarioData['id']])->first();


            if ($existUsuario) {
                throw new Exception("Ya existe un usuario con estos datos", 1);
            }

            $usuario = Usuario::find($usuarioData['id']);
            $usuario->fill($usuarioData);
            $usuario->save();

            DB::commit();
            return response()->json('Usuario editado correctamente.', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage(), 500);
        }
    }
}
