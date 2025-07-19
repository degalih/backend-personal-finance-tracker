<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = DB::table('categories')
            ->orderBy('id', )
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menampilkan daftar categories!',
            'data' => [
                'categories' => $categories
            ]
        ], Response::HTTP_OK);
    }
}
