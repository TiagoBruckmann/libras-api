<?php

namespace App\Models\quizzes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quizz extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "title",
        "banner"
    ];
    
    protected $dates = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];
}
