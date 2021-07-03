<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        // $user = User::factory()->create([
        //     'email' => 'taylor@laravel.com',
        // ]);
        $user="admin@gmail.com";
        $password="0987654321";

        $this->browse(function ($browser) use ($user,$password) {
            $browser->visit('/')
                    ->assertSee('Welcome')
                    ->visit('/register')
                    ->assertSee('Name')
                    ->assertSee('Email')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password')
                    ->type('name', 'admin')
                    ->type('email', $user)
                    ->type('password', $password)
                    ->type('password_confirmation', $password)
                    ->screenshot('Register')
                    ->press('Register')
                    ->assertPathIs('/home')
                    ->screenshot('Home');
        });
    }
}
