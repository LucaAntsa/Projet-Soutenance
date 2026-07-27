<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conseil;
use Illuminate\Http\Request;

class ConseilController extends Controller
{
    private function getLocale(Request $request): string
    {
        $locale = $request->query('lang', 'fr');

        if (!in_array($locale, ['fr', 'mg'])) {
            $locale = 'fr';
        }

        return $locale;
    }

    private function formatConseil(Conseil $conseil, string $locale): array
    {
        $data = $conseil->toArray();

        if ($locale === 'mg') {
            $data['title'] = $conseil->title_mg ?: $conseil->title_fr ?: $conseil->title;
            $data['theme'] = $conseil->theme_mg ?: $conseil->theme_fr ?: $conseil->theme;
            $data['content'] = $conseil->content_mg ?: $conseil->content_fr ?: $conseil->content;
        } else {
            $data['title'] = $conseil->title_fr ?: $conseil->title;
            $data['theme'] = $conseil->theme_fr ?: $conseil->theme;
            $data['content'] = $conseil->content_fr ?: $conseil->content;
        }

        return $data;
    }

    public function index(Request $request)
    {
        $locale = $this->getLocale($request);

        $conseils = Conseil::with('user')
            ->where('is_published', true)
            ->latest()
            ->get()
            ->map(function ($conseil) use ($locale) {
                return $this->formatConseil($conseil, $locale);
            });

        return response()->json([
            'conseils' => $conseils,
        ]);
    }

    public function show(Request $request, $id)
    {
        $locale = $this->getLocale($request);

        $conseil = Conseil::with('user')->findOrFail($id);

        return response()->json([
            'conseil' => $this->formatConseil($conseil, $locale),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'title_fr' => 'nullable|required_without:title|string|max:255',
            'title_mg' => 'nullable|string|max:255',

            'theme' => 'nullable|string|max:255',
            'theme_fr' => 'nullable|string|max:255',
            'theme_mg' => 'nullable|string|max:255',

            'content' => 'nullable|string',
            'content_fr' => 'nullable|required_without:content|string',
            'content_mg' => 'nullable|string',

            'is_published' => 'nullable|boolean',
        ]);

        $titleFr = $validated['title_fr'] ?? $validated['title'];
        $themeFr = $validated['theme_fr'] ?? ($validated['theme'] ?? null);
        $contentFr = $validated['content_fr'] ?? $validated['content'];

        $conseil = Conseil::create([
            'user_id' => $request->user()->id,

            'title' => $titleFr,
            'title_fr' => $titleFr,
            'title_mg' => $validated['title_mg'] ?? null,

            'theme' => $themeFr,
            'theme_fr' => $themeFr,
            'theme_mg' => $validated['theme_mg'] ?? null,

            'content' => $contentFr,
            'content_fr' => $contentFr,
            'content_mg' => $validated['content_mg'] ?? null,

            'is_published' => $validated['is_published'] ?? true,
        ]);

        return response()->json([
            'message' => 'Conseil créé avec succès.',
            'conseil' => $conseil->load('user'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $conseil = Conseil::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'title_fr' => 'nullable|required_without:title|string|max:255',
            'title_mg' => 'nullable|string|max:255',

            'theme' => 'nullable|string|max:255',
            'theme_fr' => 'nullable|string|max:255',
            'theme_mg' => 'nullable|string|max:255',

            'content' => 'nullable|string',
            'content_fr' => 'nullable|required_without:content|string',
            'content_mg' => 'nullable|string',

            'is_published' => 'nullable|boolean',
        ]);

        $titleFr = $validated['title_fr'] ?? $validated['title'];
        $themeFr = $validated['theme_fr'] ?? ($validated['theme'] ?? null);
        $contentFr = $validated['content_fr'] ?? $validated['content'];

        $conseil->update([
            'title' => $titleFr,
            'title_fr' => $titleFr,
            'title_mg' => $validated['title_mg'] ?? null,

            'theme' => $themeFr,
            'theme_fr' => $themeFr,
            'theme_mg' => $validated['theme_mg'] ?? null,

            'content' => $contentFr,
            'content_fr' => $contentFr,
            'content_mg' => $validated['content_mg'] ?? null,

            'is_published' => $validated['is_published'] ?? true,
        ]);

        return response()->json([
            'message' => 'Conseil modifié avec succès.',
            'conseil' => $conseil->load('user'),
        ]);
    }

    public function destroy($id)
    {
        $conseil = Conseil::findOrFail($id);
        $conseil->delete();

        return response()->json([
            'message' => 'Conseil supprimé avec succès.',
        ]);
    }
}
