<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @param \App\Models\User $user
     * @param  \App\Models\Comment $comment
     * @return bool
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }
}
