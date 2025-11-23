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
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $content = json_decode($request->content, true);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/homepage', 'public');
            $content['image'] = asset('storage/' . $imagePath);
        }

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $file) {
                $p = $file->store('uploads/homepage', 'public');
                $paths[] = asset('storage/' . $p);
            }
            $content['images'] = $paths;
            if (!isset($content['image']) && count($paths)) {
                $content['image'] = $paths[0];
            }
        }

        $section->update([
            'section_name' => $request->section_name,
            'content' => $content,
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
            'content' => 'required|json',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        // Handle image upload if exists (single + multiple)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/homepage', 'public');
        }
        $multiPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $multiPaths[] = asset('storage/' . $file->store('uploads/homepage', 'public'));
            }
        }

        // Decode JSON content
        $content = json_decode($request->content, true);

        // Add image path(s) into content JSON if image exists
        if ($imagePath) {
            $content['image'] = asset('storage/' . $imagePath);
        }
        if (!empty($multiPaths)) {
            $content['images'] = $multiPaths;
            if (!isset($content['image'])) {
                $content['image'] = $multiPaths[0];
            }
        }

        HomePageContent::create([
            'section_key' => $request->section_key,
            'section_name' => $request->section_name,
            'content' => $content,
            'is_active' => (bool) $request->is_active,
            'sort_order' => $request->sort_order ?? 0,
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
