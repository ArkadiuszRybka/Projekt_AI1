<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stone extends Model
{
    public $timestamps = false;
    protected $table = 'stones'; // Nazwa tabeli w bazie danych

    protected $fillable = [
        'name ', 'description', 'price', 'director', 'release', 'img'
    ];

}
