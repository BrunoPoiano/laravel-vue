<?php

use App\Models\Product;
use App\Models\User;

test('authenticated users can get products', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/products');
    $response->assertStatus(200);
});

test('authenticated users can get products on list', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/products/list');
    $response->assertStatus(200);
});

test('unauthenticated users cannot get products', function () {
    $response = $this->getJson('/products/list');
    $response->assertStatus(401);
});

test('authenticated users can delete products', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/products', [
        'name' => 'Test Product',
        'description' => 'Test Description',
        'price' => 100,
        'quantity' => 1
    ]);
    $response->assertStatus(201);

    $product = Product::first();
    $response = $this->delete('/products/' . $product->id);
    $response->assertStatus(200);
});

test('unauthenticated users cannot delete products', function () {
    $response = $this->deleteJson('/products/' . 1);;
    $response->assertStatus(401);
});
