<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Order extends Model
{
  protected $table = 'orders';
  protected $fillable = [
    'status',
    'totaal_bedrag',
    'customer_id',
    'betaald',
  ];
  use HasFactory;
  
public function bestelregels() {
    return $this->hasMany(Bestelregel::class);
}

   protected static function booted()
    {
        static::deleting(function ($order) {
            $order->bestelregels()->delete();
        });
    }

}
