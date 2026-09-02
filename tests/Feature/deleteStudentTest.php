<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
uses(RefreshDatabase::class);
use App\Models\Inquiry;
use App\Models\User;

test('soft delete a student',function(){
    $user=User::factory()->create(['role'=>'admin']);
        
    Sanctum::actingAs($user);
    $users=User::factory()->count(5)->create();
    $response=$this->postJson('/api/student/3/delete',[
            'status'=>'inactive'
    ]);
    $response->assertStatus(200);

});

// hard delete
test('hard delete a student',function(){
    $user=User::factory()->create(['role'=>'admin']);
        
    Sanctum::actingAs($user);
    $users=User::factory()->count(5)->create();
    $response=$this->deleteJson('/api/student/3/destroy');
    $response->assertStatus(200);

});