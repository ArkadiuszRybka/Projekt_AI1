<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    public function stone()
{
    return $this->belongsTo(Stone::class);
}

public function transaction()
{
    return $this->belongsTo(Transactions::class);
}

}
