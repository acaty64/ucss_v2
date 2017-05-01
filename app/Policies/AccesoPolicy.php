<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccesoPolicy
{
    use HandlesAuthorization;

    public function is_master(User $user)
    {
        return trim(strtolower($user->ctype)) === 'master';
    }

    public function is_consulta(User $user)
    {
        return trim(strtolower($user->ctype)) === 'consulta';
    }

	public function is_docente(User $user)
    {
        return trim(strtolower($user->ctype)) === 'docente';
    }

    public function is_responsable(User $user)
    {
        return trim(strtolower($user->ctype)) === 'responsable';
    }

    public function is_administrador(User $user)
    {
        return trim(strtolower($user->ctype)) === 'administrador';
    }
}
