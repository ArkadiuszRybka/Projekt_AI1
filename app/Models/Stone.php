<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Stone extends Model
{
    public $timestamps = false;
    protected $table = 'stones'; // Nazwa tabeli w bazie danych

    protected $fillable = [
        'name ', 'description', 'price', 'director', 'release', 'img'
    ];

    public function orders()
{
    return $this->hasMany(Orders::class);
}


}
