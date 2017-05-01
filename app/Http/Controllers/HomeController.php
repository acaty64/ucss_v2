<?php

namespace App\Http\Controllers;

use App\Facultad;
use App\Sede;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function acceso(Request $request)
    {
        $facultad=Facultad::where('wfacultad', $request->sel_facu)->first();
        $sede=Sede::where('wsede',$request->sel_sede)->first();

        \Cache::put('facultad_id',$facultad->id,60);
        \Cache::put('cfacultad',$facultad->cfacultad,60);
        \Cache::put('sede_id',$sede->id,60);
        \Cache::put('csede',$sede->csede,60);

        $usuario = Auth::user();

        if ($usuario->acceder) {
            return view('ok');
        } else {
            return back();
        }    
    }
}
