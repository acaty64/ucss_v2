<?php

use App\Menu;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Menu::create(['name' => 'Home', 'route' => 'web.clase0.home', ]);
		Menu::create(['name' => 'Option1', 'route' => 'web.clase1.func1', ]);
		Menu::create(['name' => 'Option2', ]);
		Menu::create(['name' => 'Option21', 'route' => 'web.clase2.func21', ]);
		Menu::create(['name' => 'Option22', 'route' => 'web.clase2.func22', ]);
		Menu::create(['name' => 'Option3', 'route' => 'admin.clase3.func3', ]);
		Menu::create(['name' => 'Option4', 'route' => 'api.clase4.func4', ]);


        //factory(Menu::class)->times(10)->create();

    }

}
