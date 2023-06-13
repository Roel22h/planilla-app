<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Institucion;
use Illuminate\Http\Request;

class InstitucionController extends Controller
{
    public function lista()
    {
        $instituciones = Institucion::all();

        $data = [
            'instituciones' => $instituciones
        ];

        return view('content.institucion.lista', $data);
    }

    public function agregar(Request $request)
    {
        DB::beginTransaction();


        try {
            $rolData = $request->all();

            $institucion = Institucion::where('codigo', $rolData['codigo'])->first();

            if ($institucion) {
                throw new Exception("Ya existe una institución con el mismo codigo", 1);
            }

            $newInstitucion = new Institucion();
            $newInstitucion->fill($rolData);
            $newInstitucion->save();

            DB::commit();
            return response()->json('institución registrada correctamente', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage(), 500);
        }
    }

    public function buscar(Request $request)
    {
        $id = $request->input('id');
        $institucion = Institucion::find($id);
        return response()->json($institucion, 200);
    }

    public function editar(Request $request)
    {
        DB::beginTransaction();

        try {
            $intitucionData = $request->all();

            $intitucionExist = Institucion::where(function ($query) use ($intitucionData) {
                $query->where('codigo', $intitucionData['codigo']);
            })->whereNotIn('id', [$intitucionData['id']])->first();


            if ($intitucionExist) {
                throw new Exception("Ya existe una intitucion con este codigo modular.", 1);
            }

            $intitucion = Institucion::find($intitucionData['id']);
            $intitucion->fill($intitucionData);
            $intitucion->save();

            DB::commit();
            return response()->json('Institucion editada correctamente.', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage(), 500);
        }
    }
}
