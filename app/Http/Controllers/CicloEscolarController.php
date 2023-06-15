<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\CicloEscolar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CicloEscolarController extends Controller
{
    public function agregar()
    {
        $cicloActivo = CicloEscolar::where('estado', 1)->first();

        $data = [
            'cicloActivo' => $cicloActivo
        ];

        return view('content.cicloEscolar.agregar', $data);
    }

    public function insertar(Request $request)
    {
        DB::beginTransaction();

        try {
            $cicloData = $request->all();

            $cicloEscolar = CicloEscolar::where('fin', '>=', $cicloData['inicio'])->first();

            if ($cicloEscolar) {
                throw new Exception("La fecha de inicio entrra en conflicto con otra ciclo anterior.", 1);
            }

            $newCicloEscolar = new CicloEscolar();
            $newCicloEscolar->fill($cicloData);
            $newCicloEscolar->save();

            DB::commit();
            return response()->json('Ciclo escolar registrado correctamente', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage(), 500);
        }
    }

    public function lista()
    {
        $ciclos = CicloEscolar::all();

        $data = [
            'ciclos' => $ciclos
        ];

        return view('content.cicloEscolar.lista', $data);
    }

    public function finalizar(Request $request)
    {
        DB::beginTransaction();

        try {
            $id = $request->input('id');

            $cicloEscolar = CicloEscolar::where('id', $id)->first();
            if (!$cicloEscolar) {
                throw new Exception("Ciclo escolar no identificado", 1);
            }

            $cicloEscolar = CicloEscolar::find($id);
            $cicloEscolar->estado = 0;
            $cicloEscolar->save();

            DB::commit();
            return response()->json('Ciclo escolar finalizado correctamente.', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage(), 500);
        }
    }
}
