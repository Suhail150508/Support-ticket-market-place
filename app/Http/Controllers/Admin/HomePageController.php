<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePageContent;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $sections = HomePageContent::orderBy('sort_order')->get();
        return view('admin.homepage.index', compact('sections'));
    }

    public function edit($id)
    {
        $section = HomePageContent::findOrFail($id);
        return view('admin.homepage.edit', compact('section'));
    }

    public function update(Request $request, $id)
    {
        $section = HomePageContent::findOrFail($id);
        
        $request->validate([
            'section_name' => 'required|string|max:255',
            'content' => 'required|json',
            'sort_order' => 'nullable|integer'
        ]);
        
        $section->update([
            'section_name' => $request->section_name,
            'content' => json_decode($request->content, true),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->sort_order ?? 0
        ]);

        session()->flash('success', 'Home page content updated successfully');
        return redirect()->route('admin.homepage.index');
    }
    public function create()
    {
        return view('admin.homepage.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_key' => 'required|string|max:255|unique:home_page_contents,section_key',
            'section_name' => 'required|string|max:255',
            'content' => 'required|json', // Change to 'json' validation
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);
        
      HomePageContent::create([
            'section_key' => $request->section_key,
            'section_name' => $request->section_name,
            'content' => json_decode($request->content, true),
            'is_active' => (bool) $request->is_active,
            'sort_order' => $request->sort_order ?? 0
        ]);
            session()->flash('success', 'Home page section created successfully');
        return redirect()->route('admin.homepage.index');
    }

    public function destroy($id)
    {
        $section = HomePageContent::findOrFail($id);
        $section->delete();

        session()->flash('success', 'Home page section deleted successfully');
        return redirect()->route('admin.homepage.index');
    }
}
