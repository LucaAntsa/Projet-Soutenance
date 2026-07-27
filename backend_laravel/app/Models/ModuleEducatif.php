<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleEducatif extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',

        'title',
        'title_fr',
        'title_mg',

        'description',
        'description_fr',
        'description_mg',

        'content',
        'content_fr',
        'content_mg',

        'image',
        'is_published',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function progressions()
    {
        return $this->hasMany(Progression::class);
    }
}
