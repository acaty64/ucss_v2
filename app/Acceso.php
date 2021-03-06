<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    protected $table = 'accesos';

    protected $fillable = [
        'user_id', 'sede_id', 'facultad_id', 'type_id'
    ];

}
