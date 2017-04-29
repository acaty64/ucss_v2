<?php

use App\Menu;

class RoutesTest extends TestCase
{
    function test_routes_verify()
    {
        $menus = Menu::all();
        foreach ($menus as $menu) {
        	$route = $menu->href;
        	$this->visit($route)
        		->assertResponseStatus(200);
        }
    }
}
