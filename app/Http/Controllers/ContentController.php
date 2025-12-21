<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index(Request $request) 
    {
        $contents = \App\Models\Content::latest()->get();
        return view('admin.gallery.index', compact('contents'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type'  => 'required|in:Kegiatan,Testimoni,Galeri',
            'image' => 'nullable|image|max:2048', 
            'description' => 'required|string'
        ]);

        $data = $request->except('image');
        // Handle Checkbox (if unchecked it's missing from request, so default to 0)
        $data['is_carousel'] = $request->has('is_carousel') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('contents', 'public');
        }

        \App\Models\Content::create($data);

        return redirect()->route('admin.contents.index')->with('success', 'Konten berhasil ditambahkan!');
    }

    public function edit(\App\Models\Content $content)
    {
        return view('admin.gallery.edit', compact('content'));
    }

    public function update(Request $request, \App\Models\Content $content)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type'  => 'required|in:Kegiatan,Testimoni,Galeri',
            'image' => 'nullable|image|max:2048',
            'description' => 'required|string'
        ]);

        $data = $request->except('image');
        $data['is_carousel'] = $request->has('is_carousel') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old
            if ($content->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($content->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($content->image);
            }
            $data['image'] = $request->file('image')->store('contents', 'public');
        }

        $content->update($data);

        return redirect()->route('admin.contents.index')->with('success', 'Konten berhasil diperbarui!');
    }

    public function destroy(\App\Models\Content $content)
    {
        if ($content->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($content->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($content->image);
        }
        $content->delete();
        return redirect()->route('admin.contents.index')->with('success', 'Konten dihapus!');
    }
}
