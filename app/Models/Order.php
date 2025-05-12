<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function klant() {
        return $this->belongsTo(customer::class);
    }
    public function bestelregels() {
        return $this->hasMany(Bestelregel::class);
    }
}
