<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $table = 'orders';
  protected $fillable = [
    'status',
    'totaal_bedrag',
    'customer_id',
    'betaald',
  ];
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
