<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Users API',
        ]);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json([
            'message' => 'User details',
            'user_id' => $id,
        ]);
    }
}
