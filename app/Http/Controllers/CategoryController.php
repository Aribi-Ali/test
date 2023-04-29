<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
 
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('category.categories', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->input('name');
        $category->slug = $this->generateUniqueSlug($request->name, Category::class);

        $category->name = $request->input('description');
        $category->save();


        return redirect()->route('category.index')->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->input('name');
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully');
    }

    static function generateUniqueSlug($title, $model, $separator = '-')
    {
        $slug = Str::slug($title, $separator);
        // Check if the slug already exists in the database
        $count = 0;
        $originalSlug = $slug;
        while ($model::where('slug', $slug)->exists()) {
            $count++;
            $slug = $originalSlug . $separator . $count;
        }

        return $slug;
    }
}
