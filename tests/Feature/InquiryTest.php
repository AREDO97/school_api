<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
uses(RefreshDatabase::class);
use App\Models\Inquiry;
use App\Models\User;

test('get all inquiries', function () {
    // cerate
    $user = User::factory()->create();
     Sanctum::actingAs($user);
    $response = $this->getJson('/api/inquiries');

    $response->assertStatus(200);
});
