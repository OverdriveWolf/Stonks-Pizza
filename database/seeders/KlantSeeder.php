<?php

namespace Database\Seeders;
use App\Models\customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        customer::create([
            'naam' => 'Jan Jansen',
            'adres' => 'Straatweg 123',
            'woonplaats' => 'Utrecht',
            'telefoon' => '0612345678',
            'email' => 'jan@example.com'
        ]);
    }
}
