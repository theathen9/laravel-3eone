<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Throwable;

class RegistrationController extends Controller
{
    public function index()
    {
        try {
            return view('admin.dashboard');
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'controller-error',
                'error' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }
}
