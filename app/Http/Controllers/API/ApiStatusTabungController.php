<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StatusTabung;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiStatusTabungController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        try {
            $statusTabung = StatusTabung::all();
            return response()->json([
                'success' => true,
                'message' => 'Data status tabung berhasil diambil',
                'data' => $statusTabung,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil status tabung', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data status tabung: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }
}
