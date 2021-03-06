<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Ensure new user can be created.
     *
     * @return void
     */
    public function testUserCreation()
    {
        $user = [
            'name'                  => 'Joe Smith',
            'email'                 => 'blackhole@cosst.co.uk',
            'password'              => 'passwordtest',
            'password_confirmation' => 'passwordtest',
        ];

        $response = $this->post('/register', $user);

        $response->assertRedirect('/home');

        //Remove password and password_confirmation from array
        array_splice($user, 2, 2);

        $this->assertDatabaseHas('users', $user);
    }

    /**
     * @depends testUserCreation
     */
    public function testUserLogin()
    {
        $user = [
            'email'    => 'blackhole@cosst.co.uk',
            'password' => 'passwordtest',
        ];

        $response = $this->post('/login', $user);

        $response->assertRedirect('/');
    }

    /**
     * @depends testUserLogin
     */
    public function testUserLogout()
    {
        $response = $this->post('/logout');

        $response->assertRedirect('/');
    }
}
