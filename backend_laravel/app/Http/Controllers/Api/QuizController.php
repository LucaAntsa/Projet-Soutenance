<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Score;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('moduleEducatif')->latest()->get();

        return response()->json([
            'quizzes' => $quizzes,
        ]);
    }

    public function getByModule($moduleId)
    {
        $quizzes = Quiz::with('questions.answers')
            ->where('module_educatif_id', $moduleId)
            ->get();

        return response()->json([
            'quizzes' => $quizzes,
        ]);
    }

    public function show($id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($id);

        return response()->json([
            'quiz' => $quiz,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_educatif_id' => 'required|exists:module_educatifs,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz = Quiz::create($validated);

        return response()->json([
            'message' => 'Quiz créé avec succès.',
            'quiz' => $quiz,
        ], 201);
    }

    public function addQuestion(Request $request)
    {
        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string',
            'points' => 'nullable|integer|min:1',
        ]);

        $question = Question::create([
            'quiz_id' => $validated['quiz_id'],
            'question_text' => $validated['question_text'],
            'points' => $validated['points'] ?? 1,
        ]);

        return response()->json([
            'message' => 'Question créée avec succès.',
            'question' => $question,
        ], 201);
    }

    public function addAnswer(Request $request)
    {
        $validated = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_text' => 'required|string',
            'is_correct' => 'required|boolean',
        ]);

        $answer = Answer::create($validated);

        return response()->json([
            'message' => 'Réponse créée avec succès.',
            'answer' => $answer,
        ], 201);
    }

    public function submit(Request $request, $quizId)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.answer_id' => 'required|exists:answers,id',
        ]);

        $quiz = Quiz::with('questions')->findOrFail($quizId);

        $score = 0;
        $total = $quiz->questions->sum('points');

        foreach ($validated['answers'] as $userAnswer) {
            $question = Question::find($userAnswer['question_id']);

            $answer = Answer::where('id', $userAnswer['answer_id'])
                ->where('question_id', $userAnswer['question_id'])
                ->first();

            if ($answer && $answer->is_correct) {
                $score += $question->points;
            }
        }

        $savedScore = Score::create([
            'user_id' => $request->user()->id,
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total' => $total,
        ]);

        return response()->json([
            'message' => 'Quiz soumis avec succès.',
            'score' => $savedScore,
        ]);
    }

    public function myScores(Request $request)
    {
        $scores = Score::with('quiz')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'scores' => $scores,
        ]);
    }
}
