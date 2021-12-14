<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;



    /** @test */
    public function logout_user()
    {
        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password')
        ]);

        $token = $user->createToken('android')->plainTextToke;

        $response = $this->post('/api/logout', [], [
            'Authorization' => 'Bearer ' . $token
        ]);


        $response->assertSuccessfull();

        $this->assertDatabaseCount('personal_access_token', 0);
    }
}
