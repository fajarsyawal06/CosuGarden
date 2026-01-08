<?php

// app/Http/Controllers/CostumeController.php
namespace App\Http\Controllers;

use App\Models\Costume;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CostumeController extends Controller
{
    public function index(Request $request)
    {
        $q = Costume::query()->with('category');

        if ($request->filled('search')) {
            $term = $request->string('search')->toString();
            $q->where(function ($w) use ($term) {
                $w->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            });
        }

        if ($request->filled('category_id')) {
            $q->where('category_id', $request->integer('category_id'));
        }

        if ($request->filled('min_price')) $q->where('price', '>=', $request->integer('min_price'));
        if ($request->filled('max_price')) $q->where('price', '<=', $request->integer('max_price'));

        $costumes = $q->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.costumes.index', compact('costumes', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.costumes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . Str::lower(Str::random(6));

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('costumes', 'public');
        }

        Costume::create($data);

        return redirect()->route('admin.costumes.index')->with('success', 'Costume created.');
    }

    public function edit(Costume $costume)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.costumes.edit', compact('costume', 'categories'));
    }

    public function update(Request $request, Costume $costume)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($costume->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']) . '-' . Str::lower(Str::random(6));
        }

        if ($request->hasFile('image')) {
            if ($costume->image_path) Storage::disk('public')->delete($costume->image_path);
            $data['image_path'] = $request->file('image')->store('costumes', 'public');
        }

        $costume->update($data);

        return redirect()->route('admin.costumes.index')->with('success', 'Costume updated.');
    }

    public function destroy(Costume $costume)
    {
        if ($costume->image_path) Storage::disk('public')->delete($costume->image_path);
        $costume->delete();

        return back()->with('success', 'Costume deleted.');
    }
}
