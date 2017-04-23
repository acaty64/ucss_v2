<?php

namespace App;

use App\Acceso;
use App\Menu;
use App\Type;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getNameLoginAttribute()
    {
        $rpta = $this->name;
        if ($this->sede_id) {
            $rpta = $rpta . ' (' . $this->cfacultad . ' - ' . $this->csede . ')';
        }
        if (notNullValue($this->type_id)) {
            $rpta = $rpta . ' (' . $this->type . ') ' ;
        }
        return $rpta;
    }

    public function getAccederAttribute($value)
    {
        $ok = Acceso::where('user_id', $this->id)->where('facultad_id', $this->facultad_id)->where('sede_id', $this->sede_id)->first();
        if (count($ok)) {
            Auth::user()->type_id = $ok->type_id;
            $menus = Type::find($ok->type_id)->menus;

            $original_menus = collect([]);
            foreach ($menus as $menu) {
                $original_value = $menu->original;
                $original_menus->push($original_value);
            }

            $level0 = $original_menus->where('pivot_level',0)->sortBy('pivot_order')->all();
            foreach($level0 as $level){

                if(Menu::find($level['pivot_menu_id'])->route){
                    $submenu = false;
                    $href = Menu::find($level['pivot_menu_id'])->route;
                    $description = Menu::find($level['pivot_menu_id'])->name;
                    $option = "<li><a href='".$href."'>".$description."</a></li>";
                    $options[] = $option;
                }else{
                    $submenu = true;
                    $menu_id = $level['pivot_menu_id'];
                    $menu_order = $level['pivot_order'];
                    $menu = Menu::find($menu_id);
                    $description = $menu->name;
                    $option = 
                    "<li class='dropdown'>
                        <a href='#' class='dropdown-toggle' role='button' id='dropdownMenu". $menu_order ."' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>".$description."
                            <span class='caret'></span>
                        </a>
                        <ul class='dropdown-menu' aria-labelledby='dropdownMenu". $menu_order ."'>";
                    $options[] = $option;
                }
                if($submenu == true){
                    $menu_order = $level['pivot_order'];
                    $levelx = $original_menus->where('pivot_order', $menu_order)->where('pivot_level','>',0)->sortBy('pivot_order')->all();
                    foreach ($levelx as $level) {
                        $href = Menu::find($level['pivot_menu_id'])->route;
                        $description = Menu::find($level['pivot_menu_id'])->name;
                        $option = "<li><a href='".$href."'>".$description."</a></li>";
                        $options[] = $option;
                    }
                    $options[] = "</ul></li>";
                }                
            }
            return $options;
        } else {
            return false;
        }
    }

    public function getTypeAttribute($value='')
    {
        $type_id = $this->type_id;
        if(!$type_id){
            return false;
        }else{
            $type = Type::find($type_id)->name;
            return $type;
        }
    }

    public function getUserMenuAttribute($value='')
    {
        dd('user_menu');
        if($this->acceder){
            $opciones = Menu::where('type_id',$this->type_id)->get();
            return $opciones;            
        }else{
            return false;
        }

    }
}
