<?php

use App\Acceso;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\Request;

// ROUTES

Route::get('menu/index', [
	'as'	=> 'menu.index',
	'uses'	=> 'master\MenuController@index',	
	])->middleware(Authorize::class.':is_master,'.Acceso::class);
//->middleware(Authorize::class.':isMaster,'.Acceso::class);
