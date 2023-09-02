<?php

namespace App\Http\Controllers;

use App\Helpers\Pagination;
use App\Models\Docente;
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

            $JqxgridQuotation = new jqxgridSale();
            $totalColumns = [];

            [$rows, $totalrecords, $summedColumns] = Pagination::paginate($JqxgridQuotation, $jqxParams, $totalColumns);

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
}
