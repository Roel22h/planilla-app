<?php

namespace App\Http\Controllers;

use App\Helpers\Pagination;
use App\Models\Docente;
use App\Models\Institucion;
use App\Models\jqxDocente;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    function docente()
    {
        return view('content.reporte.docente');
    }

    function docentelista(Request $request)
    {
        try {
            $jqxParams = $request->all();

            $JqxgridQuotation = new jqxDocente();
            $totalColumns = [];

            [$rows, $totalrecords, $summedColumns] = Pagination::paginate($JqxgridQuotation, $jqxParams, $totalColumns, false);

            $data = [
                'docentes' => $rows,
                'jqxParams' => $jqxParams,
                'totalrecords' => $totalrecords,
                'summedColumns' => $summedColumns,
                'message' => null
            ];

            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data = [
                'sales' => null,
                'totalrecords' => 0,
                'message' => $th->getMessage()
            ];

            return response()->json($data, 500);
        }
    }

    function institucion()
    {
        return view('content.reporte.institucion');
    }

    function institucionlista(Request $request)
    {
        try {
            $jqxParams = $request->all();

            $JqxInstitucion = new Institucion();
            $totalColumns = [];

            [$rows, $totalrecords, $summedColumns] = Pagination::paginate($JqxInstitucion, $jqxParams, $totalColumns, false);

            $data = [
                'instituciones' => $rows,
                'jqxParams' => $jqxParams,
                'totalrecords' => $totalrecords,
                'summedColumns' => $summedColumns,
                'message' => null
            ];

            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data = [
                'sales' => null,
                'totalrecords' => 0,
                'message' => $th->getMessage()
            ];

            return response()->json($data, 500);
        }
    }
}
