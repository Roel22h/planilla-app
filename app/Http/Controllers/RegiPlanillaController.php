<?php

namespace App\Http\Controllers;

use App\Models\CicloEscolar;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\RegiPlanilla;

class RegiPlanillaController extends Controller
{
    public function agregar()
    {
        $docentes = Docente::all();
        $ciclos_escolares = CicloEscolar::all();
        $data = [
            'docentes' => $docentes,
            'ciclos_escolares' => $ciclos_escolares
        ];

        return view('content.planilla.agregar', $data);
    }

    public function insertar(Request $request)
    {
        DB::beginTransaction();

        try {
            $archivo = $request->file('archivo');
            $extension = $archivo->getClientOriginalExtension();
            $path = $archivo->store('pagos_planilla');

            $newRegiPlanilla = new RegiPlanilla();

            $newRegiPlanilla->usuario_id = 1;
            $newRegiPlanilla->docente_id = $request->input('docente_id');
            $newRegiPlanilla->ciclo_escolar_id = $request->input('ciclo_escolar_id');
            $newRegiPlanilla->description = $request->input('description');
            $newRegiPlanilla->monto = $request->input('monto');
            $newRegiPlanilla->fecha = $request->input('fecha');
            $newRegiPlanilla->ruta = $path;
            $newRegiPlanilla->observacion = $request->input('observacion');

            $newRegiPlanilla->save();
            DB::commit();
            return response()->json('Pago guardado correctamente.', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage(), 500);
        }
    }

    function lista()
    {
        $regiPlanillas = RegiPlanilla::with('docente','docente.institucion', 'cicloEscolar')->get();

        $data = [
            'regiPlanillas' => $regiPlanillas
        ];

        return view('content.planilla.lista', $data);
    }
}
