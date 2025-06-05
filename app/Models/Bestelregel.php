<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bestelregel extends Model
{
    public function bestelling() {
        return $this->belongsTo(Bestelling::class);
    }
    public function pizza() {
        return $this->belongsTo(Pizza::class);
    }
    protected $fillable = ['order_id', 'pizza_id', 'aantal'];
public $timestamps = true;

}
