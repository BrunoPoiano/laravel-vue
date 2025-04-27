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
