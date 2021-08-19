<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

# repositories
use App\Repositories\Auth\AuthRepository;

# models
use App\Models\levels\level;

class LevelsController extends Controller
{
    public function getLevels(Request $request)
    {
        $bearerToken = $request->bearerToken();
        $repository = new AuthRepository();

        $userId = $repository->getUserID($bearerToken);

        $data = level::select(
            'id',
            'name'
        )
            ->get();
        
        return response()->json($data);
    }
}
