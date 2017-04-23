<?php

use App\Type;
use Illuminate\Database\Seeder;

class MenuTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $type = Type::find(1);
        $type->menus()->sync([
                1 => ['level'=>0, 'order' =>0],
                2=> ['level'=>0, 'order' =>1]
            ]);
        $type = Type::find(2);
        $type->menus()->sync([
                1 => ['level'=>0, 'order' =>0],
                2 => ['level'=>0, 'order' =>1],
                3 => ['level'=>0, 'order' =>2],
                4 => ['level'=>1, 'order' =>2],
                5 => ['level'=>2, 'order' =>2],
                6 => ['level'=>0, 'order' =>3]
            ]);
        $type = Type::find(2);
        $type->menus()->sync([
                1 => ['level'=>0, 'order' =>0],
                2 => ['level'=>0, 'order' =>1],
                3 => ['level'=>0, 'order' =>2],
                4 => ['level'=>1, 'order' =>2],
                5 => ['level'=>2, 'order' =>2],
                6 => ['level'=>0, 'order' =>3],
                7 => ['level'=>0, 'order' =>4],
            ]);


    }

}
