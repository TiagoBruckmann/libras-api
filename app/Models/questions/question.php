<?php

namespace App\Models\questions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "quizz_id",
        "awnser_id",
        "level_id",
        "category_id"
    ];

}
