<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
uses(RefreshDatabase::class);
use App\Models\Inquiry;
use App\Models\User;



test('only admins create new students', function () {

$user=User::factory()->create([
        'role'=>'super_admin'
]);

Sanctum::actingAs($user);
    $response = $this->postJson('/api/student/create',[
        'name'=>'Ivan Joe',
        'email'=>'van@gmail.com'
    ]);

    $response->assertStatus(201);
});


