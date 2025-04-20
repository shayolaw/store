<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Product;
use Tests\TestCase;
use App\Models\User;

class productTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void{
        parent::setUp();
        $user = User::factory()->create();
        $this->actingAs($user);

    }

    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {

        $response = $this->get('/products');
        $response->assertJsonIsArray();
    }
    public function test_create(){
        $response = $this->post('/products', [
            'name' => 'Product 1',
            'description' => 'Description 1',
            'price' => 1000,
            // 'category_id' => 1,
            'in_stock' => 1,
        ]);
        $response->assertJsonStructure([
            'name',
            'description',
            'price',
            // 'category_id',
            'in_stock',
        ]);
    }

    public function test_update(){
        $product = Product::factory()->create();
        $url = '/products/update/' . $product->id;
        $response = $this->put($url, [
            'name' => 'Product 1',
            'description' => 'Description 1',
            'price' => 1000,
            // 'category_id' => 1,
            'in_stock' => 1,
        ]);
        $response->assertJsonStructure([
            'name',
            'description',
            'price',
            // 'category_id',
            'in_stock',
        ]);
    }
    public function test_delete(){
        $product = Product::factory()->create();
        $response = $this->delete('/products/delete/' . $product->id);
        $response->assertSuccessful();
    }
    public function test_show(){
        $product = Product::factory()->create();
        $response = $this->get('/products/show/' . $product->id);
        $response->assertJsonStructure([
            'name',
            'description',
            'price',
            // 'category_id',
            'in_stock',
        ]);
    }
    public function test_form(){
        $response = $this->get('/products/form');
        $response->assertSuccessful();
    }
}
