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

// update student

test('update student info', function () {

$user=User::factory()->create();

Sanctum::actingAs($user);
    $response = $this->postJson('/api/student/1/update',[
        'name'=>'sammy',
        'email'=>'van4@gmail.com'
    ]);

    $response->assertStatus(200);
});


