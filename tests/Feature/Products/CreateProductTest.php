<?php

use App\Models\User;

test('authenticated users can create products', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/products', [
        'name' => 'Test Product',
        'description' => 'Test Description',
        'price' => 100,
        'quantity' => 1
    ]);
    $response->assertStatus(201);
});

test('authenticated users cannot create products without name', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/products', [
        'description' => 'Test Description',
        'price' => 100,
        'quantity' => 1
    ]);
    $response->assertStatus(422);
});

test('authenticated users can create products without description', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/products', [
        'name' => 'Test Product',
        'price' => 100,
        'quantity' => 1
    ]);
    $response->assertStatus(201);
});

test('authenticated users cannot create products without price', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/products', [
        'name' => 'Test Product',
        'description' => 'Test Description',
        'quantity' => 1
    ]);
    $response->assertStatus(422);
});

test('authenticated users cannot create products without quantity', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/products', [
        'name' => 'Test Product',
        'description' => 'Test Description',
        'price' => 100
    ]);
    $response->assertStatus(422);
});
