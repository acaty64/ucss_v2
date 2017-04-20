<?php

namespace App\Http\Controllers;

use App\Facultad;
use App\Sede;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $facultad=Facultad::where('wfacultad', $request->sel_facu)->get();
        $sede=Sede::where('wsede',$request->sel_sede)->get();

        Auth::user()->facultad_id = $facultad[0]->id;
        Auth::user()->cfacultad = $facultad[0]->cfacultad;
        Auth::user()->sede_id = $sede[0]->id;
        Auth::user()->csede = $sede[0]->csede;
        $usuario = Auth::user();

        if ($usuario->acceder) {
            return view('ok');
        } else {
            return back();
        }    
    }
}
