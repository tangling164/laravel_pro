<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use APP\Models\User;
use App\Models\Status;

class StatusPolicy
{
    use HandlesAuthorization;
    public function __construct()
    {
        //
    }

    public function destroy(User $user,Status $status)
    {
        return $user->id === $status->user_id;
    }
}
