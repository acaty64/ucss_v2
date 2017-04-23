<?php 

use App\Acceso;
use App\Facultad;
use App\Sede;
use App\Type;
use App\User;

class MenuTest extends TestCase
{
	function test_user_menu()
	{
		// Having
		$user = $this->defaultUser();
		$facultad = Facultad::find(1);
		$sede = Sede::find(1);
		$type = Type::find(3);

		$acceso = factory(Acceso::class)->create([
            'user_id'   	=> $user->id,
            'facultad_id'	=> $facultad->id,
            'sede_id'		=> $sede->id,
            'type_id'		=> $type->id,
        ]);

		// When
		$this->actingAs($user)
			->visit('/home')
			->select($facultad->wfacultad,'sel_facu')
			->select('Lima','sel_sede')
			->press('Acceder');

		// Then
		$opcion = $type->menu->name->first();
		$this->see($opcion);

	}

}