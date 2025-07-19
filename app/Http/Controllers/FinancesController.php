<?php

namespace App\Http\Controllers;

use App\Imports\FinancesImport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class FinancesController extends Controller
{
    public function importRecord(Request $request):JsonResponse {
//        $validator = Validator::make($request->all(), [
//            'csv' => ['required', 'mimes:csv'],
//        ]);

//        if ($validator->fails()) {
//            return response()->json([
//                'status' => 'error',
//                'message' => 'Validasi gagal',
//                'errors' => $validator->errors()->all()
//            ], Response::HTTP_UNPROCESSABLE_ENTITY);
//        }

        $file = $request->file('csv');

        Excel::import(new FinancesImport, $file);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengimport data!',
        ], Response::HTTP_OK);
    }
}
