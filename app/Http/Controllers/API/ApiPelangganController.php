<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApiPelangganRequest;
use App\Http\Requests\UpdateApiPelangganRequest;
use App\Http\Resources\ApiPelangganCollection;
use App\Http\Resources\ApiPelangganResource;
use App\Models\Akun;
use App\Models\Perorangan;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ApiPelangganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
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
                'email_perusahaan' => $user->perorangan->perusahaan->email_perusahaan ?? null,
                'alamat_perusahaan' => $user->perorangan->perusahaan->alamat_perusahaan ?? null,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diambil',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil profil pelanggan', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil profil: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        try {
            $pelanggan = Perorangan::with(['akun', 'perusahaan'])
                ->whereNull('deleted_at')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Daftar pelanggan berhasil diambil',
                'data' => new ApiPelangganCollection($pelanggan),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil daftar pelanggan', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil daftar pelanggan: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $perorangan = Perorangan::with(['akun', 'perusahaan'])->whereNull('deleted_at')->find($id);
            if (!$perorangan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Pelanggan tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Detail pelanggan berhasil diambil',
                'data' => $perorangan,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil detail pelanggan', ['error' => $e->getMessage(), 'id' => $id]);

            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil detail pelanggan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreApiPelangganRequest $request): JsonResponse
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $perusahaan = null;
                if ($request['nama_perusahaan']) {
                    $perusahaan = Perusahaan::create([
                        'nama_perusahaan' => $request['nama_perusahaan'],
                        'alamat_perusahaan' => $request['alamat_perusahaan'],
                        'email_perusahaan' => $request['email_perusahaan'],
                    ]);
                }

                $perorangan = Perorangan::create([
                    'nama_lengkap' => $request['nama_lengkap'],
                    'nik' => $request['nik'],
                    'no_telepon' => $request['no_telepon'],
                    'alamat' => $request['alamat'],
                    'id_perusahaan' => $perusahaan?->id_perusahaan,
                ]);

                if ($request['email']) {
                    Akun::create([
                        'id_perorangan' => $perorangan->id_perorangan,
                        'email' => $request['email'],
                        'password' => bcrypt($request['password']),
                        'role' => 'pelanggan',
                        'status_aktif' => true,
                    ]);
                }

                return $perorangan->load(['akun', 'perusahaan']);
            });

            return response()->json([
                'status' => true,
                'message' => 'Pelanggan berhasil ditambahkan',
                'data' => new ApiPelangganResource($result),
            ], 201);
        } catch (\Exception $e) {
            Log::error('Gagal menambah pelanggan', ['error' => $e->getMessage(), 'request' => $request->$request->toArray()()]);
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah pelanggan: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    public function update(UpdateApiPelangganRequest $request, $id): JsonResponse
    {
        try {
            $result = DB::transaction(function () use ($request, $id) {
                $perorangan = Perorangan::with(['akun', 'perusahaan'])->findOrFail($id);

                // Update Perusahaan
                $perusahaan = $perorangan->perusahaan;
                if ($request['nama_perusahaan']) {
                    if ($perusahaan) {
                        $perusahaan->update([
                            'nama_perusahaan' => $request['nama_perusahaan'],
                            'alamat_perusahaan' => $request['alamat_perusahaan'],
                            'email_perusahaan' => $request['email_perusahaan'],
                        ]);
                    } else {
                        $perusahaan = Perusahaan::create([
                            'nama_perusahaan' => $request['nama_perusahaan'],
                            'alamat_perusahaan' => $request['alamat_perusahaan'],
                            'email_perusahaan' => $request['email_perusahaan'],
                        ]);
                    }
                } elseif ($perusahaan) {
                    $perusahaan->delete();
                    $perusahaan = null;
                }

                // Update Perorangan
                $perorangan->update([
                    'nama_lengkap' => $request['nama_lengkap'],
                    'nik' => $request['nik'],
                    'no_telepon' => $request['no_telepon'],
                    'alamat' => $request['alamat'],
                    'id_perusahaan' => $perusahaan?->id_perusahaan,
                ]);

                // Update Akun
                if ($request['email']) {
                    if ($perorangan->akun) {
                        $perorangan->akun->update([
                            'email' => $request['email'],
                            'password' => $request['password'] ? bcrypt($request['password']) : $perorangan->akun->password,
                        ]);
                    } else {
                        Akun::create([
                            'id_perorangan' => $perorangan->id_perorangan,
                            'email' => $request['email'],
                            'password' => bcrypt($request['password']),
                            'role' => 'pelanggan',
                            'status_aktif' => true,
                        ]);
                    }
                } elseif ($perorangan->akun) {
                    $perorangan->akun->delete();
                }

                return $perorangan->load(['akun', 'perusahaan']);
            });

            return response()->json([
                'status' => true,
                'message' => 'Pelanggan berhasil diperbarui',
                'data' => new ApiPelangganResource($result),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui pelanggan', [
                'error' => $e->getMessage(),
                'customer_id' => $id,
                'request' => $request->$request->toArray()(),
            ]);
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui pelanggan: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    public function destroy($id)
    {
        $perorangan = Perorangan::findOrFail($id);
        $perorangan->delete();

        return response()->json(['message' => 'Pelanggan berhasil dihapus']);
    }
}
