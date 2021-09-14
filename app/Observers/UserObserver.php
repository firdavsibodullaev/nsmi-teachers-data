<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param User $user
     * @return void
     */
    public function creating(User $user)
    {
        $user->Password = bcrypt($user->Password);
    }

    /**
     * @param User $user
     */
    public function updating(User $user)
    {
        if (request()->has('Password')) {
            $user->Password = bcrypt($user->Password);
            return;
        }
        unset($user->Password);
    }
}
