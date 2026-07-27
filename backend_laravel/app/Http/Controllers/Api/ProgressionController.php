<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Progression;
use Illuminate\Http\Request;

class ProgressionController extends Controller
{
    public function index(Request $request)
    {
        $progressions = Progression::with('moduleEducatif.category')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'progressions' => $progressions,
        ]);
    }

    public function storeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'module_educatif_id' => 'required|exists:module_educatifs,id',
            'progress_percentage' => 'required|integer|min:0|max:100',
        ]);

        $progression = Progression::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'module_educatif_id' => $validated['module_educatif_id'],
            ],
            [
                'progress_percentage' => $validated['progress_percentage'],
                'is_completed' => $validated['progress_percentage'] >= 100,
            ]
        );

        return response()->json([
            'message' => 'Progression enregistrée avec succès.',
            'progression' => $progression->load('moduleEducatif.category'),
        ]);
    }

    public function completeModule(Request $request, $moduleId)
    {
        $progression = Progression::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'module_educatif_id' => $moduleId,
            ],
            [
                'progress_percentage' => 100,
                'is_completed' => true,
            ]
        );

        return response()->json([
            'message' => 'Module marqué comme terminé.',
            'progression' => $progression->load('moduleEducatif.category'),
        ]);
    }
}
