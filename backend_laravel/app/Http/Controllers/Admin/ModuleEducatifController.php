<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ModuleEducatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleEducatifController extends Controller
{
    public function index()
    {
        $modules = ModuleEducatif::with('category', 'user')
            ->latest()
            ->get();

        return view('admin.modules.index', compact('modules'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.modules.create', compact('categories'));
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

            'is_published' => 'nullable|boolean',
        ]);

        $titleFr = $validated['title_fr'] ?? $validated['title'];
        $descriptionFr = $validated['description_fr'] ?? ($validated['description'] ?? null);
        $contentFr = $validated['content_fr'] ?? $validated['content'];

        ModuleEducatif::create([
            'category_id' => $validated['category_id'] ?? null,
            'user_id' => Auth::id(),

            'title' => $titleFr,
            'title_fr' => $titleFr,
            'title_mg' => $validated['title_mg'] ?? null,

            'description' => $descriptionFr,
            'description_fr' => $descriptionFr,
            'description_mg' => $validated['description_mg'] ?? null,

            'content' => $contentFr,
            'content_fr' => $contentFr,
            'content_mg' => $validated['content_mg'] ?? null,

            'is_published' => $request->has('is_published'),
        ]);

        return redirect()
            ->route('admin.modules.index')
            ->with('success', 'Module éducatif ajouté avec succès.');
    }

    public function edit($id)
    {
        $module = ModuleEducatif::findOrFail($id);
        $categories = Category::all();

        return view('admin.modules.edit', compact('module', 'categories'));
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

            'is_published' => $request->has('is_published'),
        ]);

        return redirect()
            ->route('admin.modules.index')
            ->with('success', 'Module éducatif modifié avec succès.');
    }

    public function destroy($id)
    {
        $module = ModuleEducatif::findOrFail($id);
        $module->delete();

        return redirect()
            ->route('admin.modules.index')
            ->with('success', 'Module éducatif supprimé avec succès.');
    }
}
