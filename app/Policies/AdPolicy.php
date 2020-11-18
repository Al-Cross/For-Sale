<?php

namespace App\Policies;

use App\Ad;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can create threads.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->ad_limit !== 0;
    }

    /**
     * Determine whether the user can update threads.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user, Ad $ad)
    {
        return $ad->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete threads.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user, Ad $ad)
    {
        return $ad->user_id == $user->id;
    }
}
