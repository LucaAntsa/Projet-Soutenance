<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModuleEducatif;
use Illuminate\Http\Request;

class ModuleEducatifController extends Controller
{
    private function getLocale(Request $request): string
    {
        $locale = $request->query('lang', 'fr');

        if (!in_array($locale, ['fr', 'mg'])) {
            $locale = 'fr';
        }

        return $locale;
    }

    private function formatModule(ModuleEducatif $module, string $locale): array
    {
        $data = $module->toArray();

        if ($locale === 'mg') {
            $data['title'] = $module->title_mg ?: $module->title_fr ?: $module->title;
            $data['description'] = $module->description_mg ?: $module->description_fr ?: $module->description;
            $data['content'] = $module->content_mg ?: $module->content_fr ?: $module->content;
        } else {
            $data['title'] = $module->title_fr ?: $module->title;
            $data['description'] = $module->description_fr ?: $module->description;
            $data['content'] = $module->content_fr ?: $module->content;
        }

        return $data;
    }

    public function index(Request $request)
    {
        $locale = $this->getLocale($request);

        $modules = ModuleEducatif::with(['category', 'user'])
            ->where('is_published', true)
            ->latest()
            ->get()
            ->map(function ($module) use ($locale) {
                return $this->formatModule($module, $locale);
            });

        return response()->json([
            'modules' => $modules,
        ]);
    }

    public function show(Request $request, $id)
    {
        $locale = $this->getLocale($request);

        $module = ModuleEducatif::with(['category', 'user', 'quizzes'])
            ->findOrFail($id);

        return response()->json([
            'module' => $this->formatModule($module, $locale),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',

            'title' => 'nullable|string|max:255',
            'title_fr' => 'nullable|required_without:title|string|max:255',
            'title_mg' => 'nullable|string|max:255',

            'description' => 'nullable|string',
            'description_fr' => 'nullable|string',
            'description_mg' => 'nullable|string',

            'content' => 'nullable|string',
            'content_fr' => 'nullable|required_without:content|string',
            'content_mg' => 'nullable|string',

            'image' => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);

        $titleFr = $validated['title_fr'] ?? $validated['title'];
        $descriptionFr = $validated['description_fr'] ?? ($validated['description'] ?? null);
        $contentFr = $validated['content_fr'] ?? $validated['content'];

        $module = ModuleEducatif::create([
            'category_id' => $validated['category_id'] ?? null,
            'user_id' => $request->user()->id,

            'title' => $titleFr,
            'title_fr' => $titleFr,
            'title_mg' => $validated['title_mg'] ?? null,

            'description' => $descriptionFr,
            'description_fr' => $descriptionFr,
            'description_mg' => $validated['description_mg'] ?? null,

            'content' => $contentFr,
            'content_fr' => $contentFr,
            'content_mg' => $validated['content_mg'] ?? null,

            'image' => $validated['image'] ?? null,
            'is_published' => $validated['is_published'] ?? true,
        ]);

        return response()->json([
            'message' => 'Module éducatif créé avec succès.',
            'module' => $module->load(['category', 'user']),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $module = ModuleEducatif::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',

            'title' => 'nullable|string|max:255',
            'title_fr' => 'nullable|required_without:title|string|max:255',
            'title_mg' => 'nullable|string|max:255',

            'description' => 'nullable|string',
            'description_fr' => 'nullable|string',
            'description_mg' => 'nullable|string',

            'content' => 'nullable|string',
            'content_fr' => 'nullable|required_without:content|string',
            'content_mg' => 'nullable|string',

            'image' => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);

        $titleFr = $validated['title_fr'] ?? $validated['title'];
        $descriptionFr = $validated['description_fr'] ?? ($validated['description'] ?? null);
        $contentFr = $validated['content_fr'] ?? $validated['content'];

        $module->update([
            'category_id' => $validated['category_id'] ?? null,

            'title' => $titleFr,
            'title_fr' => $titleFr,
            'title_mg' => $validated['title_mg'] ?? null,

            'description' => $descriptionFr,
            'description_fr' => $descriptionFr,
            'description_mg' => $validated['description_mg'] ?? null,

            'content' => $contentFr,
            'content_fr' => $contentFr,
            'content_mg' => $validated['content_mg'] ?? null,

            'image' => $validated['image'] ?? null,
            'is_published' => $validated['is_published'] ?? true,
        ]);

        return response()->json([
            'message' => 'Module éducatif modifié avec succès.',
            'module' => $module->load(['category', 'user']),
        ]);
    }

    public function destroy($id)
    {
        $module = ModuleEducatif::findOrFail($id);
        $module->delete();

        return response()->json([
            'message' => 'Module éducatif supprimé avec succès.',
        ]);
    }
}
