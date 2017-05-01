<?php

namespace App;

use App\Acceso;
use App\Menu;
use App\Type;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
        $cfacultad = Cache::get('cfacultad');
        $csede = Cache::get('csede');
        $ctype = Cache::get('ctype');

        $rpta = $this->name;
        if ($cfacultad) {
            $rpta = $rpta . ' (' . $cfacultad . ' - ' . $csede . ')';
        }
        if (notNullValue($ctype)) {
            $rpta = $rpta . ' (' . $ctype . ')' ;
        }
        return $rpta;
    }

    public function getAccederAttribute($value)
    {
        $facultad_id = Cache::get('facultad_id');
        $sede_id = Cache::get('sede_id');
        $ok = Acceso::where('user_id', $this->id)->where('facultad_id', $facultad_id)->where('sede_id', $sede_id)->first();
        if (count($ok) && $facultad_id) {
            $type_id = $ok->type_id;
            Cache::put('type_id', $type_id, 60);
            $ctype = Type::find($type_id)->name;
            Cache::put('ctype', $ctype, 60);

            $menus = Type::find($ok->type_id)->menus;

            $original_menus = collect([]);
            foreach ($menus as $menu) {
                $original_value = $menu->original;
                $original_menus->push($original_value);
            }

            $level0 = $original_menus->where('pivot_level',0)->sortBy('pivot_order')->all();
            foreach($level0 as $level){
                if($level['href']){
                    $submenu = false;
                    $option = "<li><a href='".$level['href']."'>".$level['name']."</a></li>";
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
}
