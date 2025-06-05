<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    public function bestellingen() {
        return $this->hasMany(Bestelling::class);
    }
    protected $fillable = [
        'naam',
        'adres',
        'woonplaats',
        'email',
        'telefoon',
    ];
}
