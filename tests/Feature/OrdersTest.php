<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use App\Models\User;
use App\Models\Orders;

class OrdersTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected function setUp(): void{
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

    }
    public function test_get(): void
    {
        $response = $this->get('/orders');

        $response->assertStatus(200);
        $response->assertJsonIsArray();
    }
    public function test_successful_save(){
        $payload = Orders::factory()->make()->toArray();
        $response = $this->post('/orders',$payload);
        $response->assertStatus((200));
        $response->assertJsonIsObject();
    }
    public function test_save_validation(){
        $payload = [
            "total_price" => "12.99",
            "sub_total" => "10.99",
            "status" => "Created",
            'total_tax' => "2.00"
        ];
        $response = $this->postJson('/orders',$payload);
        $response->assertJsonValidationErrors(['user_id']);
    }
    public function test_update_tax(){
        $payload = Orders::factory()->create();
        $payload = $payload->toArray();
        $payload['total_tax'] = 10.00;
        $response = $this->put('/orders/'.$payload['id'],$payload);
        $response->assertStatus(200);
        $response->assertJsonIsObject();
        $response->assertJsonFragment([
            'total_tax' => 10.00,
        ]);
    }
    public function test_show(){
        $payload = Orders::factory()->create()->toArray();
        $response = $this->get('/orders/'.$payload['id']);
        $response->assertStatus(200);
        $response->assertJsonIsObject();
    }
    public function test_delete(){
        $payload = Orders::factory()->create()->toArray();
        Log::info('id of deleted order is' .$payload['id']);
        $response = $this->delete('/orders/delete/'.$payload['id']);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('orders', [
            'id' => $payload['id'],
        ]);
    }
}
