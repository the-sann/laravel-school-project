<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use \App\Traits\HasNavs;
    public function index()
    {
        $navs = $this->getNavs();
        $categories = Category::all();
        return view('categories.index', compact('categories', 'navs'));
    }
    public function create()
    {
        $navs = $this->getNavs();
        return view('categories.create', compact('navs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
        ]);

        Category::create($request->only('name'));

        return redirect()->route('categories.index')->with('success', 'Category added successfully');
    }
    public function edit(Category $category)
    {
        $navs = $this->getNavs();
        return view('categories.edit', compact('category', 'navs'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->only('name'));

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted');
    }
}
