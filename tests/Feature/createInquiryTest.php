<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
uses(RefreshDatabase::class);
use App\Models\Inquiry;
use App\Models\User;

test('create inquiry', function () {
    $user=User::factory()->create();
    Sanctum::actingAs($user);
    $response = $this->postJson('api/inquiry/create',[
        'user_id'=>$user->id,
        'phone'=>"+256 767222023",
        'title'=>"fees",
        'message'=>'hello'
    ]);

    $response->assertStatus(201);
});
