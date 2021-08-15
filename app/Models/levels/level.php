<?php

namespace App\Models\levels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class level extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name"
    ];
    
    protected $dates = [
        "created_at",
        "updated_at"
    ];
}
