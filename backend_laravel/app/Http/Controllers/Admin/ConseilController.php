<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conseil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConseilController extends Controller
{
    public function index()
    {
        $conseils = Conseil::with('user')
            ->latest()
            ->get();

        return view('admin.conseils.index', compact('conseils'));
    }

    public function create()
    {
        return view('admin.conseils.create');
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

        Conseil::create([
            'user_id' => Auth::id(),

            'title' => $titleFr,
            'title_fr' => $titleFr,
            'title_mg' => $validated['title_mg'] ?? null,

            'theme' => $themeFr,
            'theme_fr' => $themeFr,
            'theme_mg' => $validated['theme_mg'] ?? null,

            'content' => $contentFr,
            'content_fr' => $contentFr,
            'content_mg' => $validated['content_mg'] ?? null,

            'is_published' => $request->has('is_published'),
        ]);

        return redirect()
            ->route('admin.conseils.index')
            ->with('success', 'Conseil ajouté avec succès.');
    }

    public function edit($id)
    {
        $conseil = Conseil::findOrFail($id);

        return view('admin.conseils.edit', compact('conseil'));
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

            'is_published' => $request->has('is_published'),
        ]);

        return redirect()
            ->route('admin.conseils.index')
            ->with('success', 'Conseil modifié avec succès.');
    }

    public function destroy($id)
    {
        $conseil = Conseil::findOrFail($id);
        $conseil->delete();

        return redirect()
            ->route('admin.conseils.index')
            ->with('success', 'Conseil supprimé avec succès.');
    }
}
