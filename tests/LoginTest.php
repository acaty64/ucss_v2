<?php

use App\User;

class LoginTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_a_guest_can_register()
    {
        $this->visit('/')
             ->click('Register')
             ->seePageIs('/register')
             ->type('Jane Doe', 'name')
             ->type('jdoe@gmail.com', 'email')
             ->type('secret','password')
             ->type('secret','password_confirmation')
             ->press('Register');
        // Then
        $this->seeInDatabase('users',[
                'name' => 'Jane Doe',
                'email' => 'jdoe@gmail.com'
            ]);
    }

    function test_a_user_can_login()
    {
        // Having
        User::create([
                'name' => 'Jane Doe',
                'email' => 'jdoe@gmail.com',
                'password'  => bcrypt('secret')
            ]);
        // Acting
        $this->visit('/login')
            ->seePageIs('/login')
            ->type('jdoe@gmail.com', 'email')
            ->type('secret','password')
            ->press('Login');
        // Then
        $this->seePageIs('/home');
    }

}
