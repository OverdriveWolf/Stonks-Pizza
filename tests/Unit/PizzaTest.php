<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Pizza;
use App\Models\Order;
use App\Models\Bestelregel;
use App\Models\Customer;
use App\Models\Ingredient;
use Carbon\Carbon;

class PizzaTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_the_cart_index_with_orders()
    {
        $order = Order::factory()->create(['status' => 'Betaald']);
        Bestelregel::factory()->create(['order_id' => $order->id]);

        $response = $this->get(route('winkelwagentje.index'));

        $response->assertStatus(200);
        $response->assertViewIs('winkelwagentje');
        $response->assertViewHas('orders');
    }

    public function test_it_creates_a_new_order_with_pizza_and_customer()
    {
        $pizza = Pizza::factory()->create(['prijs' => 10.00]);
        $ingredient = Ingredient::factory()->create();

        $response = $this->post(route('winkelwagentje.store'), [
            'pizza_id' => $pizza->id,
            'grootte' => 'groot',
            'naam' => 'Jan',
            'woonplaats' => 'Amsterdam',
            'adres' => 'Damstraat 1',
            'email' => 'test@example.com',
            'telefoonnummer' => '+31612345678',
            'ingredients' => [$ingredient->id],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('customers', ['naam' => 'Jan']);
        $this->assertDatabaseHas('orders', ['status' => 'Initieel']);
        $this->assertDatabaseHas('bestelregels', ['pizza_id' => $pizza->id]);
    }

  
    public function test_it_increments_a_bestelregel()
    {
        $regel = Bestelregel::factory()->create(['aantal' => 1]);

        $response = $this->post(route('winkelwagentje.increment'), [
            'regel_id' => $regel->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('bestelregels', [
            'id' => $regel->id,
            'aantal' => 2,
        ]);
    }

    
    public function test_it_decrements_a_bestelregel_and_deletes_when_zero()
    {
        $regel = Bestelregel::factory()->create(['aantal' => 1]);

        $response = $this->patch(route('winkelwagentje.decrement'), [
            'regel_id' => $regel->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseMissing('bestelregels', ['id' => $regel->id]);
    }

   
    public function test_it_marks_orders_as_paid()
    {
        $order = Order::factory()->create(['status' => 'Initieel']);

        $response = $this->post(route('bestelling.betaal'), [
            'ids' => [$order->id],
        ]);

        $response->assertRedirect(route('winkelwagentje.index'));
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'Betaald',
        ]);
    }


    public function test_it_removes_an_order()
    {
        $order = Order::factory()->create();

        $response = $this->post(route('winkelwagentje.remove'), [
            'id' => $order->id,
        ]);

        $response->assertRedirect(route('winkelwagentje.index'));
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }


    public function test_it_creates_a_quick_order()
    {
        $pizza = Pizza::factory()->create(['prijs' => 12.00]);

        $response = $this->post(route('quickOrder.store', $pizza), [
            'grootte' => 'normaal',
            'naam' => 'Piet',
            'woonplaats' => 'Rotterdam',
            'adres' => 'Kerkstraat 5',
            'email' => 'piet@example.com',
            'telefoonnummer' => '+31698765432',
        ]);

        $response->assertRedirect(route('winkelwagentje.index'));
        $this->assertDatabaseHas('orders', ['status' => 'Initieel']);
    }


    public function test_it_deletes_old_delivered_orders_after_10_seconds()
    {
        $order = Order::factory()->create([
            'status' => 'Bezorgd',
            'updated_at' => Carbon::now()->subSeconds(11),
        ]);

        $this->get(route('winkelwagentje.index'));

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
 }