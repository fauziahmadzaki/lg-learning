<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['title', 'description', 'image', 'type', 'is_carousel'];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
             return asset('storage/' . $this->image);
        }

        // Kalau null, return placeholder default
        return 'https://ui-avatars.com/api/?name='.urlencode($this->title).'&background=random';
    }
}
