<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Content;
use App\Services\ContentService;
use App\Http\Requests\StoreContentRequest;
use App\Http\Requests\UpdateContentRequest;

class ContentController extends Controller
{
    public function __construct(
        private ContentService $contentService,
    ) {}

    public function index()
    {
        $contents = Content::latest()->get();
        return view('admin.gallery.index', compact('contents'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(StoreContentRequest $request)
    {
        $data = $request->validated();
        $data['is_carousel'] = $request->has('is_carousel') ? 1 : 0;
        $data['image'] = $this->contentService->handleImage($request);

        $this->contentService->create($data);

        return redirect()->route('admin.contents.index')->with('success', 'Konten berhasil ditambahkan!');
    }

    public function edit(Content $content)
    {
        return view('admin.gallery.edit', compact('content'));
    }

    public function update(UpdateContentRequest $request, Content $content)
    {
        $data = $request->validated();
        $data['is_carousel'] = $request->has('is_carousel') ? 1 : 0;

        if ($request->hasFile('image')) {
            $this->contentService->deleteImage($content->image);
            $data['image'] = $this->contentService->handleImage($request);
        }

        $this->contentService->update($content, $data);

        return redirect()->route('admin.contents.index')->with('success', 'Konten berhasil diperbarui!');
    }

    public function destroy(Content $content)
    {
        $this->contentService->delete($content);
        return redirect()->route('admin.contents.index')->with('success', 'Konten dihapus!');
    }
}
