<?php

use App\Acceso;
use App\Facultad;
use App\Sede;
use App\Type;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class LoginValuesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_auth_preliminar_value()
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
        $this->assertEquals(null,Auth::user()->facu_id);

    }

    public function test_auth_post_value()
    {
        //Having
        $user=$this->defaultUser();
        $facultad = Facultad::find(1);
		$sede = Sede::find(1);
		$type = Type::find(1);
        $acceso = factory(Acceso::class)->create([
            'user_id'   	=> $user->id,
            'facultad_id'	=> 1,
            'sede_id'		=> 1,
            'type_id'		=> 1,
        ]);
        // When
        $this->actingAs($user)
			->visit('/home')
			->select($facultad->wfacultad,'sel_facu')
			->select($sede->wsede,'sel_sede')
			->press('Acceder');

		// Then
		$this->see('Menus')
			->assertEquals(1,Auth::user()->facultad_id);

/** TODO: with Laravel-Dusk
		// When
		$this->Click('Logout');
			->assertEquals(null,Auth::user()->facultad_id);
*/
    }

}
