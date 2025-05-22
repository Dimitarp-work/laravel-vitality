<?php

namespace App\Policies;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**This policy is added to policies in AuthServiceProvider*/
class ChallengePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Challenge $challenge): bool
    {
        // allow viewing if the user is a participant or the creator
        return $challenge->participants->contains($user) || $challenge->creator_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // any logged-in user can create challenges
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Challenge $challenge): bool
    {
        return $challenge->creator_id === $user->id;
    }

    public function delete(User $user, Challenge $challenge): bool
    {
        return $challenge->creator_id === $user->id;
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Challenge $challenge): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Challenge $challenge): bool
    {
        //
    }
}
