<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Pizza extends Model
{
    use HasFactory;
    public function ingredients() {
        return $this->belongsToMany(Ingredient::class);
    }
}
