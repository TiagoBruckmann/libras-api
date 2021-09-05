<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

# repositories
use App\Repositories\Auth\AuthRepository;

# model
use App\Models\categories\category;

class CategoriesController extends Controller
{
    public function getCategories(Request $request)
    {
        $bearerToken = $request->bearerToken();
        $repository = new AuthRepository();

        $userId = $repository->getUserID($bearerToken);

        $data = category::select(
            'id',
            'name'
        )
            ->whereNull('deleted_at')
            ->paginate(10);
        
        return response()->json($data);
    }
}
