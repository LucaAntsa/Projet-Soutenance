<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progression extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'module_educatif_id',
        'is_completed',
        'progress_percentage',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function moduleEducatif()
    {
        return $this->belongsTo(ModuleEducatif::class);
    }
}
