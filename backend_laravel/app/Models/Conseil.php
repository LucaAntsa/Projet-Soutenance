<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conseil extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'title',
        'title_fr',
        'title_mg',

        'theme',
        'theme_fr',
        'theme_mg',

        'content',
        'content_fr',
        'content_mg',

        'is_published',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
