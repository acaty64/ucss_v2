<?php

use App\Type;
use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    public function run()
    {
        factory(Type::class)->create([
        	'name' => 'Usuario Tipo A'
        ]);
        factory(Type::class)->create([
            'name' => 'Usuario Tipo B'
        ]);
        factory(Type::class)->create([
            'name' => 'Usuario Tipo C'
        ]);
    }
}
