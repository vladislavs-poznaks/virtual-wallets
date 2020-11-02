<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_register()
    {
        $this->get(route('register'))
            ->assertSee('Registration Form');

        $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'testpassword1234',
            'password_confirmation' => 'testpassword1234',
        ]);

        $this->assertEquals('Test User', User::where('email', 'test@example.com')->first()->name);
    }

    /**
     * @test
     */
    public function a_user_can_login()
    {
        $this->get(route('login'))
            ->assertSee('Login');

        $this->assertGuest($guard = null);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('testpassword1234')
        ]);

        $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'testpassword1234',
        ]);

        $this->assertAuthenticatedAs($user, $guard = null);
    }
}
