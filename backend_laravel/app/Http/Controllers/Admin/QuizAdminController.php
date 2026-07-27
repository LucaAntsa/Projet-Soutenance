<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\ModuleEducatif;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizAdminController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('moduleEducatif')
            ->latest()
            ->get();

        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $modules = ModuleEducatif::all();

        return view('admin.quizzes.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_educatif_id' => 'required|exists:module_educatifs,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz = Quiz::create($validated);

        return redirect()
            ->route('admin.quizzes.show', $quiz->id)
            ->with('success', 'Quiz créé avec succès.');
    }

    public function show($id)
    {
        $quiz = Quiz::with('moduleEducatif', 'questions.answers')
            ->findOrFail($id);

        return view('admin.quizzes.show', compact('quiz'));
    }

    public function addQuestion(Request $request, $id)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'points' => 'required|integer|min:1',

            'answer_1' => 'required|string',
            'answer_2' => 'required|string',
            'answer_3' => 'nullable|string',
            'answer_4' => 'nullable|string',
            'correct_answer' => 'required|in:1,2,3,4',
        ]);

        $quiz = Quiz::findOrFail($id);

        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => $validated['question_text'],
            'points' => $validated['points'],
        ]);

        for ($i = 1; $i <= 4; $i++) {
            $answerText = $validated['answer_' . $i] ?? null;

            if ($answerText) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $answerText,
                    'is_correct' => $validated['correct_answer'] == $i,
                ]);
            }
        }

        return redirect()
            ->route('admin.quizzes.show', $quiz->id)
            ->with('success', 'Question ajoutée avec succès.');
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return redirect()
            ->route('admin.quizzes.index')
            ->with('success', 'Quiz supprimé avec succès.');
    }
}
