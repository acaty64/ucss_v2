<?php

namespace App;

use App\Acceso;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        if ($this->sede_id) {
            return $this->name . ' (' . $this->cfacultad . ' - ' . $this->csede . ')';
        } else {
            return $this->name;
        }
    }

    public function getAccederAttribute($value)
    {
        $ok = Acceso::where('user_id', $this->id)->where('facultad_id', $this->facultad_id)->where('sede_id', $this->sede_id)->get();
        if (count($ok)) {
            return true;
        } else {
            return false;
        }
    }
}
