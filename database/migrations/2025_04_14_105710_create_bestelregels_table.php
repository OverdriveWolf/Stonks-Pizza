<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bestelregels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('pizza_id')->constrained('pizzas')->onDelete('cascade');
            $table->integer('aantal');
            $table->decimal('prijs', 8, 2);
            $table->string('afmeting')->default('normaal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bestelregels');
    }
};
