<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class customer extends Model
{
     use HasFactory;
    public function bestellingen() {
        return $this->hasMany(Order::class);
    }
    protected $fillable = [
        'naam',
        'adres',
        'woonplaats',
        'email',
        'telefoon',
    ];
}
