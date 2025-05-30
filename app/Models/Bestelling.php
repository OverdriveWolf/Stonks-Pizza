<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bestelling extends Model
{
  protected $table = 'orders';
  protected $fillable = [
    'status',
    'totaal_bedrag',
    'klant_id',
    'betaald',
  ];
  public function bestelregels()
  {
    return $this->hasMany(Bestelregel::class);
  }
  public function klant()
  {
    return $this->belongsTo(Klant::class);
  } 
}
