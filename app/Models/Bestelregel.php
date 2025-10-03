<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Bestelregel extends Model
{ 
    use HasFactory;
    public function bestelling() {
        return $this->belongsTo(Order::class);
    }
    public function pizza() {
        return $this->belongsTo(Pizza::class);
    }
    protected $fillable = ['order_id', 'pizza_id', 'aantal', 'prijs', 'afmeting'];
public $timestamps = true;


public function ingredients()
{
    return $this->belongsToMany(Ingredient::class, 'bestelregel_ingredient');
}

}
