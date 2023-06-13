<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{
	public function lista()
	{
		$roles = Rol::all();

		$data = [
			'roles' => $roles
		];

		return view('content.rol.lista', $data);
	}

	public function agregar(Request $request)
	{
		DB::beginTransaction();

		try {
			$rolData = $request->all();

			$rol = Rol::where('descripcion', $rolData['descripcion'])->first();

			if ($rol) {
				throw new Exception("Ya existe un rol con la misma descripcion", 1);
			}

			$newRol = new Rol();
			$newRol->fill($rolData);
			$newRol->save();

			DB::commit();
			return response()->json('Rol registrado correctamente', 200);
		} catch (\Throwable $th) {
			DB::rollBack();
			return response()->json($th->getMessage(), 500);
		}
	}

	public function buscar(Request $request)
	{
		$id = $request->input('id');
		$rol = Rol::find($id);
		return response()->json($rol, 200);
	}

	public function editar(Request $request)
	{
		DB::beginTransaction();

		try {
			$rolData = $request->all();

			$rolExist = Rol::where(function ($query) use ($rolData) {
				$query->where('descripcion', $rolData['descripcion']);
			})->whereNotIn('id', [$rolData['id']])->first();


			if ($rolExist) {
				throw new Exception("Ya existe un rol con estos datos", 1);
			}

			$rol = Rol::find($rolData['id']);
			$rol->fill($rolData);
			$rol->save();

			DB::commit();
			return response()->json('Rol editado correctamente.', 200);
		} catch (\Throwable $th) {
			DB::rollBack();
			return response()->json($th->getMessage(), 500);
		}
	}
}
