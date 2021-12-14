<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;



    /** @test */
    public function login_existing_user()
    {
        $user = User::create([
            'name' => 'User',
            'email' =>  'user@gmail.com',
            'password' => bcrypt('secret')
        ]);


        $response = $this->post('/api/login', [
            
            'email' => $user->email,
            'password' => 'secret',
            'device_name' => 'android'
        ]);

        
        $response->assertSuccessful();
        $this->assertNotEmpty($response->getContent());
        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'android',
            'tokenable_type' => User::class,
            'tokenable_id' => $user->id
        ]);
        }

    /** @test */
    public function get_user_from_token()
    {
        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('secret')
        ]);

        $token = $user->createToken('android')->plainTextToken;

        $response = $this->get('/api/user', [
            'Authorization' => 'Bearer ' . $token
        ]);


        $response->assertSuccessful();

        $response->assertJson(function($json) {
            $json->where('email', 'user@gmail.com')
            ->missing('password')
            ->etc();
        });
    }
    
    
}
