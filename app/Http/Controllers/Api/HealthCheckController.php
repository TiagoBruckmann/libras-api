<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class HealthCheckController extends Controller
{
    public function healthCheck(Request $request)
    {
        try {
            DB::connection()->getPdo();

            return response()->json([
                'Sanity Test #0' => 'Okay, Houston, we have no problem here.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Okay, Houston, we have a problem here.',
                'error' => 'Database connection unavailable'
            ], 500);
        }

    }
}
