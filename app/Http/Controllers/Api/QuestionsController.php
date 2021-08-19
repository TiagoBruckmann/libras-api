<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

# repositories
use App\Repositories\Auth\AuthRepository;

# models
use App\Models\questions\question;

class QuestionsController extends Controller
{
    public function memoryGame(Request $request)
    {
        $bearerToken = $request->bearerToken();
        $repository = new AuthRepository();

        $userId = $repository->getUserID($bearerToken);

        if (!$request->filled('level_id')) {
            return response()->json([
                'message' => 'A request parameter is missing - level_id',
                'status_code' => 400
            ], 400);
        }

        $levelId = $request->input('level_id');

        if (!$request->filled('category_id')) {
            return response()->json([
                'message' => 'A request parameter is missing - category_id',
                'status_code' => 400
            ], 400);
        }

        $categoryId = $request->input('category_id');

        $data = question::select(
            'awnsers.id',
            'awnsers.awnser',
            'awnsers.banner'
        )
            ->leftJoin('awnsers', 'questions.awnser_id', 'awnsers.id')
            ->where('questions.level_id', $levelId)
            ->where('questions.category_id', $categoryId)
            ->get();

        return response()->json($data);
    }

    public function quizzGame(Request $request)
    {
        $bearerToken = $request->bearerToken();
        $repository = new AuthRepository();

        $userId = $repository->getUserID($bearerToken);

        if (!$request->filled('level_id')) {
            return response()->json([
                'message' => 'A request parameter is missing - level_id',
                'status_code' => 400
            ], 400);
        }

        $levelId = $request->input('level_id');

        if (!$request->filled('category_id')) {
            return response()->json([
                'message' => 'A request parameter is missing - category_id',
                'status_code' => 400
            ], 400);
        }

        $categoryId = $request->input('category_id');

        $data = question::select(
            'quizzes.id',
            'quizzes.title',
            'quizzes.banner as question_banner',
            'awnsers.awnser',
            'awnsers.banner as awnser_banner',
            'awnsers.is_rigth'
        )
            ->leftJoin('quizzes', 'questions.quizz_id', 'quizzes.id')
            ->leftJoin('awnsers', 'questions.awnser_id', 'awnsers.id')
            ->where('questions.level_id', $levelId)
            ->where('questions.category_id', $categoryId)
            ->get();

        return response()->json($data);
    }
}
