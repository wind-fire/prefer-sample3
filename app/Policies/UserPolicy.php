<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

    /*public function __construct()
    {
        //
    }*/

    /**
     * @param User $currentUser 当前用户
     * @param User $user 需要授权用户
     * @return bool
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
