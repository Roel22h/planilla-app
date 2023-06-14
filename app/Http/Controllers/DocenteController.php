<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Docente;
use App\Models\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocenteController extends Controller
{
    public function lista()
    {
        $docentes = Docente::with('institucion')->get();
        $instituciones = Institucion::where('estado', 1)->get();

        $data = [
            'docentes' => $docentes,
            'instituciones' => $instituciones
        ];

        return view('content.docente.lista', $data);
    }

    public function agregar(Request $request)
    {
        DB::beginTransaction();
        try {
            $docenteData = $request->all();

            $docente = Docente::where('dni', $docenteData['dni'])
                ->first();

            if ($docente) {
                throw new Exception("Ya existe un docente con esos datos", 1);
            }

            $newDocente = new Docente();
            $newDocente->fill($docenteData);
            $newDocente->save();

            DB::commit();
            return response()->json('Docente registrado correctamente.', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage(), 500);
        }
    }

    public function buscar(Request $request)
    {
        $id = $request->input('id');
        $docente = Docente::find($id);
        return response()->json($docente, 200);
    }

    public function editar(Request $request)
    {
        DB::beginTransaction();

        try {
            $docenteData = $request->all();

            $existDocente = Docente::where(function ($query) use ($docenteData) {
                $query->where('dni', $docenteData['dni']);
            })->whereNotIn('id', [$docenteData['id']])->first();


            if ($existDocente) {
                throw new Exception("Ya existe un docente con estos datos", 1);
            }

            $docente = Docente::find($docenteData['id']);
            $docente->fill($docenteData);
            $docente->save();

            DB::commit();
            return response()->json('Docente editado correctamente.', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage(), 500);
        }
    }
}
