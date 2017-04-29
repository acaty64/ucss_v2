<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccesoPolicy
{
    use HandlesAuthorization;

    public function is_master(User $user)
    {
        return $user->cType === 'master';
    }

    public function is_consulta(User $user)
    {
        return $user->cType === 'consulta';
    }

	public function is_docente(User $user)
    {
        return $user->cType === 'docente';
    }

    public function is_responsable(User $user)
    {
        return $user->cType === 'responsable';
    }
}
