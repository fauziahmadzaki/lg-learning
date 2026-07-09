<?php

namespace App\Services;

use App\Models\Content;
use Illuminate\Support\Facades\Storage;

class ContentService
{
    public function create(array $data): Content
    {
        return Content::create([
            'title'       => $data['title'],
            'type'        => $data['type'],
            'image'       => $data['image'] ?? null,
            'description' => $data['description'] ?? null,
            'is_carousel' => $data['is_carousel'] ?? false,
        ]);
    }

    public function update(Content $content, array $data): void
    {
        $updateData = [
            'title'       => $data['title'] ?? $content->title,
            'type'        => $data['type'] ?? $content->type,
            'description' => $data['description'] ?? $content->description,
            'is_carousel' => $data['is_carousel'] ?? $content->is_carousel,
        ];

        if (!empty($data['image'])) {
            $updateData['image'] = $data['image'];
        }

        $content->update($updateData);
    }

    public function delete(Content $content): void
    {
        $this->deleteImage($content->image);
        $content->delete();
    }

    public function handleImage($request): ?string
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('content', 'public');
        }
        return null;
    }

    public function deleteImage(?string $image): void
    {
        if ($image && Storage::disk('public')->exists($image)) {
            Storage::disk('public')->delete($image);
        }
    }
}
