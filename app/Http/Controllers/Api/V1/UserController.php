<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $users = User::with('reference')
            ->where('status', 1)
            ->orderBy('user_id', 'asc')
            ->get();

        $users->each(function ($user) {
            $user->profile_image = $user->reference?->profile_image;
        });

        return response()->json([
            'success' => true,
            'message' => 'Users retrieved successfully',
            'data' => $users,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::with('reference')
            ->where('status', 1)
            ->find($id);

        if (! $user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        $user->profile_image = $user->reference?->profile_image;

        return response()->json([
            'message' => 'User retrieved successfully',
            'data' => $user,
        ]);
    }
}
