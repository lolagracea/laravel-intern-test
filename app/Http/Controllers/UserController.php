<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * [GET] /api/users
     * Menampilkan semua user beserta daftar hobi mereka
     */
    public function index(): JsonResponse
    {
        $users = User::with('hobbies')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data user berhasil diambil.',
            'data'    => $users,
        ], 200);
    }

    /**
     * [POST] /api/users
     * Menambah user baru
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::create([
            'nama'  => $request->nama,
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan.',
            'data'    => $user,
        ], 201);
    }
}