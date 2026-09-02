<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
uses(RefreshDatabase::class);
use App\Models\Inquiry;
use App\Models\User;

test('allows logged in user to access an inquiry', function () {
    $user=User::Factory()->create();
    Sanctum::actingAs($user);
        // create inquiry
    $inquiry=Inquiry::Factory()->count(3)->create([
        'user_id'=>$user->id
    ]);
    $response = $this->getJson('/api/inquiry/1/access');

    $response->assertStatus(200);
});
