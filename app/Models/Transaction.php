<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stones extends Model
{
    use HasFactory;

    public function stones()
{
    return $this->hasMany(Stone::class);
}
}
