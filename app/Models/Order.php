<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
public function bestelregels()
{
    return $this->hasMany(Bestelregel::class, 'order_id');
}


}
