<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecordResource;
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

    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => ['nullable'],
            'limit' => ['nullable'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->all()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);

        $records = DB::table("finances")
            ->orderBy("created_at", "desc")
            ->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menampilkan sesi Jadwal UAS!',
            'data' => [
                'records' => RecordResource::collection($records),
                'pagination' => [
                    'current_page' => $records->currentPage(),
                    'total_pages' => $records->lastPage(),
                    'total_items' => $records->total(),
                    'per_page' => $records->perPage(),
                    'from' => $records->firstItem(),
                    'to' => $records->lastItem(),
                ]
            ]
        ], Response::HTTP_OK);
    }
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
