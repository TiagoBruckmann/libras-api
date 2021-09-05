<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

# models
use App\Models\users\User;

# repositories
use App\Repositories\Auth\AuthRepository;

class UsersController extends Controller
{
    public function getUser(Request $request)
    {
        $bearerToken = $request->bearerToken();
        $repository = new AuthRepository();

        $userId = $repository->getUserID($bearerToken);

        $data = User::select(
            'id',
            'name',
            'level',
            'qty_level',
            'next_level'
        )
            ->firstWhere('id', $userId);

        if ($data->qty_level > 0) {
            $calc1 = $data->next_level - $data->qty_level;
            $calc2 = $calc1/$data->qty_level;
            $percent = $calc2 * 100;
            $next_level = 100 - substr($percent, 0, 2);
            $data->next_level = number_format($next_level, 1, '.');
        } else {
            $data->next_level = "0";
        }

        return response()->json($data);
    }

    public function updateLevel(Request $request)
    {
        $bearerToken = $request->bearerToken();
        $repository = new AuthRepository();

        $userId = $repository->getUserID($bearerToken);

        if (!$request->filled('qty_level')) {
            return response()->json([
                'message' => 'A request parameter is missing - qty_level',
                'status_code' => 400
            ], 400);
        }

        $level = $request->input('level');
        $qty_level = $request->input('qty_level');

        $data = User::find($userId);
        
        $calcLevel = $data->qty_level + $qty_level;
        $calcTotalLevel = $data->total_level + $qty_level;
        
        # cai apenas nivel 1
        if ($data->level == 1 && $calcLevel < $data->next_level) {    
            $data->qty_level = $calcLevel;
            $data->total_level = $calcLevel;
            $data->save();

            return response()->noContent();
        }

        # atualiza para o proximo nivel
        if ($calcLevel >= $data->next_level) {
            $level = $data->level + 1;
            
            if ($data->level <= 5) {
                $calcNextLevel = $data->next_level * 1.5;
            } else {
                $calcNextLevel = $data->next_level * 1.2;
            }
            
            $calcQtyLevel = $calcLevel - $data->next_level;
            
            if ($calcLevel == $data->next_level) {
                $data->level = $level;
                $data->qty_level = 0;
                $data->total_level = $calcTotalLevel;
                $data->next_level = $calcNextLevel;
                $data->save();

                return response()->noContent();
            }

            $data->level = $level;
            $data->qty_level = $calcQtyLevel;
            $data->total_level = $calcTotalLevel;
            $data->next_level = $calcNextLevel;
            $data->save();

            return response()->noContent();

        } else {
            # mantem o nivel mas atualiza outros valores
            
            $data->qty_level = $calcLevel;
            $data->total_level = $calcTotalLevel;
            $data->save();

            return response()->noContent();
        }
    }
}
