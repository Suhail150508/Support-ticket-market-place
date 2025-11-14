<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('department')->orderBy('name')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get(['id','name']);
        return view('admin.categories.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        Category::create($validated);

        session()->flash('success', 'Category created successfully');
        return redirect()->route('admin.categories.index');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $departments = Department::orderBy('name')->get(['id','name']);
        return view('admin.categories.edit', compact('category','departments'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $category->update($validated);

        session()->flash('success', 'Category updated successfully');
        return redirect()->route('admin.categories.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        session()->flash('success', 'Category deleted successfully');
        return redirect()->route('admin.categories.index');
    }
}

