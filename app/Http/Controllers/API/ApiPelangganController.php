<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApiPelangganRequest;
use App\Http\Requests\UpdateApiPelangganRequest;
use App\Models\Akun;
use App\Models\Perorangan;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiPelangganController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    //     $this->middleware(function ($request, $next) {
    //         if (Auth::user()->role !== 'pelanggan') {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Akses hanya untuk pelanggan'
    //             ], 403);
    //         }
    //         return $next($request);
    //     });
    // }

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function profile(): JsonResponse
    {
        try {
            $user = Auth::user()->load('perorangan.perusahaan');
            $data = [
                'id_akun' => $user->id_akun,
                'email' => $user->email,
                'role' => $user->role,
                'status_aktif' => $user->status_aktif,
                'nama_lengkap' => $user->perorangan->nama_lengkap ?? null,
                'nik' => $user->perorangan->nik ?? null,
                'no_telepon' => $user->perorangan->no_telepon ?? null,
                'alamat' => $user->perorangan->alamat ?? null,
                'nama_perusahaan' => $user->perorangan->perusahaan->nama_perusahaan ?? null,
                'alamat_perusahaan' => $user->perorangan->perusahaan->alamat_perusahaan ?? null,
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Gagal mengambil profil pelanggan', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil profil: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function index(): JsonResponse
    {
        $pelanggans = Perorangan::with(['akun', 'perusahaan'])
            ->whereHas('akun', function ($query) {
                $query->where('role', 'pelanggan');
            })
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $pelanggans
        ]);
    }

    public function store(StoreApiPelangganRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Buat data perorangan
            $perorangan = Perorangan::create([
                'nama_lengkap' => $request->nama_lengkap,
                'nik' => $request->nik,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'id_perusahaan' => $request->id_perusahaan,
            ]);

            // Buat akun jika is_authenticated true
            if ($request->is_authenticated) {
                Akun::create([
                    'id_perorangan' => $perorangan->id_perorangan,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'pelanggan',
                    'status_aktif' => true,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Pelanggan berhasil ditambahkan.',
                'data' => $perorangan->load(['akun', 'perusahaan']),
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan pelanggan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        $perorangan = Perorangan::with(['akun', 'perusahaan'])->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $perorangan
        ]);
    }

    public function update(UpdateApiPelangganRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $perorangan = Perorangan::findOrFail($id);

            // Update data perorangan
            $perorangan->update([
                'nama_lengkap' => $request->nama_lengkap ?? $perorangan->nama_lengkap,
                'nik' => $request->nik ?? $perorangan->nik,
                'no_telepon' => $request->no_telepon ?? $perorangan->no_telepon,
                'alamat' => $request->alamat ?? $perorangan->alamat,
                'id_perusahaan' => $request->id_perusahaan ?? $perorangan->id_perusahaan,
            ]);

            // Update atau buat akun
            if ($request->has('email') || $request->has('password') || $request->has('status_aktif')) {
                $akun = $perorangan->akun ?? new Akun(['id_perorangan' => $perorangan->id_perorangan]);
                $akun->email = $request->email ?? $akun->email;
                if ($request->has('password') && $request->password) {
                    $akun->password = Hash::make($request->password);
                }
                $akun->status_aktif = $request->status_aktif ?? $akun->status_aktif ?? true;
                $akun->role = 'pelanggan';
                $akun->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Pelanggan berhasil diperbarui.',
                'data' => $perorangan->load(['akun', 'perusahaan']),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui pelanggan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $perorangan = Perorangan::findOrFail($id);
            $perorangan->delete(); // Akun akan dihapus otomatis karena onDelete('cascade')

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Pelanggan berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus pelanggan: ' . $e->getMessage(),
            ], 500);
        }
    }
}