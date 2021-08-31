<?php

namespace App\Models\awnsers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class awnser extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "awnser",
        "banner"
    ];
    
    protected $dates = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];
}
