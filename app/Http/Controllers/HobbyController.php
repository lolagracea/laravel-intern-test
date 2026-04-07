<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HobbyController extends Controller
{
    /**
     * [POST] /api/hobbies
     * Menambah hobi baru
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nama_hobi' => 'required|string|max:255',
            'user_id'   => 'required|integer|exists:users,id',
        ]);

        $existingHobby = Hobby::where('nama_hobi', $request->nama_hobi)
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingHobby) {
            return response()->json([
                'success' => false,
                'message' => 'Hobi sudah ada untuk user ini.',
            ], 409);
        }

        $hobby = Hobby::create([
            'nama_hobi' => $request->nama_hobi,
            'user_id'   => $request->user_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Hobi berhasil ditambahkan.',
            'data'    => $hobby->load('user'),
        ], 201);
    }

    /**
     * [DELETE] /api/hobbies/{id}
     * Menghapus hobi berdasarkan ID
     */
    public function destroy(int $id): JsonResponse
    {
        $hobby = Hobby::findOrFail($id);

        $hobby->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hobi berhasil dihapus.',
        ], 200);
    }
}