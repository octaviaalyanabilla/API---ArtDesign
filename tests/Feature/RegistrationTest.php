<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** test */

    public function register_new_user()
    {
        $response = $this->post('/api/registrtion', [
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'device_name' => 'android'
        ]);

        $response->assertSuccessfull();

        $this->assertNotEmpty($response->getContent());
        $this->assertDatabaseHas('users', ['email' => 'user@gmail.com']);
        $this->assertDatabaseHas('personal_access_tokens', ['name' => 'android']);
    }
}
