<?php

use App\Models\Product;
use App\Models\User;

test('authenticated users can edit products', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/products', [
        'name'        => 'Test Product',
        'description' => 'Test Description',
        'price'       => 100,
        'quantity'    => 1,
    ]);
    $response->assertStatus(201);

    $product  = Product::first();
    $response = $this->putJson('/products/'.$product->id, [
        'name'        => 'Updated Product',
        'description' => 'Updated Description',
        'price'       => 200,
        'quantity'    => 2,
    ]);
    $response->assertStatus(200);
});

test('unauthenticated users cannot edit products', function () {
    $response = $this->putJson('/products/'. 1, [
        'name'        => 'Test Product',
        'description' => 'Test Description',
        'price'       => 100,
        'quantity'    => 1,
    ]);
    $response->assertStatus(401);
});

test('authenticated users cannot edit products without name', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/products', [
        'name'        => 'Test Product',
        'description' => 'Test Description',
        'price'       => 100,
        'quantity'    => 1,
    ]);
    $response->assertStatus(201);

    $product  = Product::first();
    $response = $this->putJson('/products/'.$product->id, [
        'description' => 'Updated Description',
        'price'       => 200,
        'quantity'    => 2,
    ]);
    $response->assertStatus(422);
});

test('authenticated users can edit products without description', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/products', [
        'name'        => 'Test Product',
        'description' => 'Test Description',
        'price'       => 100,
        'quantity'    => 1,
    ]);
    $response->assertStatus(201);

    $product  = Product::first();
    $response = $this->putJson('/products/'.$product->id, [
        'name'     => 'Updated Product',
        'price'    => 200,
        'quantity' => 2,
    ]);
    $response->assertStatus(200);
});

test('authenticated users cannot edit products without price', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/products', [
        'name'        => 'Test Product',
        'description' => 'Test Description',
        'price'       => 100,
        'quantity'    => 1,
    ]);
    $response->assertStatus(201);

    $product  = Product::first();
    $response = $this->putJson('/products/'.$product->id, [
        'name'        => 'Updated Product',
        'description' => 'Updated Description',
        'quantity'    => 2,
    ]);
    $response->assertStatus(422);
});

test('authenticated users cannot edit products without quantity', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/products', [
        'name'        => 'Test Product',
        'description' => 'Test Description',
        'price'       => 100,
        'quantity'    => 1,
    ]);
    $response->assertStatus(201);

    $product  = Product::first();
    $response = $this->putJson('/products/'.$product->id, [
        'name'        => 'Updated Product',
        'description' => 'Updated Description',
        'price'       => 200,
    ]);
    $response->assertStatus(422);
});

test('authenticated users cannot edit products that are not found', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/products', [
        'name'        => 'Test Product',
        'description' => 'Test Description',
        'price'       => 100,
        'quantity'    => 1,
    ]);
    $response->assertStatus(201);

    $product  = Product::first();
    $response = $this->putJson('/products/'. 999, [
        'name'        => 'Updated Product',
        'description' => 'Updated Description',
        'price'       => 200,
    ]);
    $response->assertStatus(404);
});

test('authenticated users cannot edit products that is not his own', function () {

    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/products', [
        'name'        => 'Test Product',
        'description' => 'Test Description',
        'price'       => 100,
        'quantity'    => 1,
    ]);
    $response->assertStatus(201);

    $user_product = Product::first();
    $response     = $this->putJson('/products/'.$user_product->id, [
        'name'        => 'Updated Product',
        'description' => 'Updated Description',
        'price'       => 200,
        'quantity'    => 2,
    ]);
    $response->assertStatus(200);

    $second_user = User::factory()->create();
    $this->actingAs($second_user);

    $response = $this->putJson('/products/'.$user_product->id, [
        'name'        => 'Updated Product',
        'description' => 'Updated Description',
        'price'       => 200,
        'quantity'    => 2,
    ]);
    $response->assertStatus(403);

});
