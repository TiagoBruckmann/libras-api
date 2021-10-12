<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

# repositories
use App\Repositories\Auth\AuthRepository;

# models
use App\Models\questions\question;
use App\Models\awnsers\awnser;
use App\Models\users\User;

class QuestionsController extends Controller
{

    public function quizzGame(Request $request)
    {
        $bearerToken = $request->bearerToken();
        $repository = new AuthRepository();

        $userId = $repository->getUserID($bearerToken);

        if (!$request->filled('category_id')) {
            return response()->json([
                'message' => 'A request parameter is missing - category_id',
                'status_code' => 400
            ], 400);
        }

        $categoryId = $request->input('category_id');

        $user = User::find($userId);
        if ($user->level <= 5) {
            $levelId = 1;
        } else if ($user->level > 5 && $user->level <= 10) {
            $levelId = rand(1, 2);
        } else if ($user->level > 10 && $user->level <= 15) {
            $levelId = rand(1, 3);
        } else {
            $levelId = rand(1, 4);
        }

        if ($categoryId == 1) {

            $data = question::select(
                'quizzes.id',
                'quizzes.title',
                'quizzes.banner',
                'questions.awnser_id'
            )
                ->leftJoin('quizzes', 'questions.quizz_id', 'quizzes.id')
                ->where('questions.level_id', $levelId)
                ->limit(1)
                ->inRandomOrder()
                ->first();

        } else {
            $data = question::select(
                'quizzes.id',
                'quizzes.title',
                'quizzes.banner',
                'questions.awnser_id'
            )
                ->leftJoin('quizzes', 'questions.quizz_id', 'quizzes.id')
                ->where('questions.level_id', $levelId)
                ->where('questions.category_id', $categoryId)
                ->limit(1)
                ->inRandomOrder()
                ->first();
        }

        $awnsers = awnser::select(
            'id',
            'awnser'
        )
            # ->where('id', '<>', $data->awnser_id)
            ->limit(3)
            ->inRandomOrder()
            ->get();

        $awnserRight = awnser::select(
            'id',
            'awnser'
        )
            ->firstWhere("id", $data->awnser_id);
        
        # $encode = json_encode(array_merge(json_decode($awnsers, true), json_decode($awnserRight, true)));
        
        return response()->json([
            "question" => $data,
            "awnsers" => $awnsers,
            "right" => $awnserRight,
            "question_level" => $levelId
        ]);
    }
}
