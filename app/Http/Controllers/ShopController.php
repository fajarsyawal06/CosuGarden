<?php

// app/Http/Controllers/ShopController.php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Costume;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $q = Costume::query()->with('category');

        if ($request->filled('search')) {
            $term = $request->string('search')->toString();
            $q->where('name', 'like', "%{$term}%");
        }

        if ($request->filled('category')) {
            $q->whereHas('category', fn($c) => $c->where('slug', $request->string('category')));
        }

        $costumes = $q->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('shop.index', compact('costumes', 'categories'));
    }

    public function show(Costume $costume)
    {
        $costume->load('category');
        return view('shop.show', compact('costume'));
    }
}
