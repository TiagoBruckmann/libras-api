<?php

namespace App\Models\categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name"
    ];
    
    protected $dates = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];
}
