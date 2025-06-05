<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Winkelwagentje extends Model
{
public function ingredients()
{
    return $this->belongsToMany(Ingredient::class, 'ingredient_order', 'order_id', 'ingredient_id');
}


}
