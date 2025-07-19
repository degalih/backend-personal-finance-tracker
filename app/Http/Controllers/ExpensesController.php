<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ExpensesController extends Controller
{
    public function importExpenses(Request $request):JsonResponse {
        $validator = Validator::make($request->all(), [
            'csv' => ['required', 'mimes:csv'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->all()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $file = $request->file('csv');
        $handle = fopen($file, 'r');

        fgetcsv($handle);

        // Jumlah Baris Data yang akan diproses sekaligus dalam satu waktu
        $chunkSize = 25;

        while(!feof($handle)){
            $chunkData = [];

            for ($i=0; $i<$chunkSize; $i++) {
                $data = fgetcsv($handle);
                if($data === false){
                    break;
                }
                $chunkData[] = $data;
            }

            $this->getChunkData($chunkData);
        }

        fclose($handle);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengimport data!',
        ], Response::HTTP_OK);
    }

    private function getChunkData(array $chunkData): void
    {
        foreach ($chunkData as $column) {
            $description = $column[0];
            $category = $column[1];
            $amount = $column[2];
            $date = $column[3];

            DB::table('expenses')
                ->insert([
                    'description' => $description,
                    'category' => $category,
                    'amount' => $amount,
                    'date' => $date,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }
    }
}
