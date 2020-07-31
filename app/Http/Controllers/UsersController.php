<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        if (!$user = User::find($id)) {
            return response()->json([
                'status' => 'GAGAL',
                'pesan' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'OK',
            'data' => $user
        ]);
    }
}
