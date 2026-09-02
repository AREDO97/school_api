<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
uses(RefreshDatabase::class);
use App\Models\Inquiry;
use App\Models\User;

test('access all students', function () {
    $users=User::Factory()->count(3)->create([
        'role'=>'student'
    ]);
    $user=User::factory()->create([
        'role'=>'admin'
    ]);
    Sanctum::actingAs($user);
    $response = $this->getJson('/api/students/all');

    $response->assertStatus(200);
});
