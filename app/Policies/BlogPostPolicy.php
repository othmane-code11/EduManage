<?php

namespace App\Policies;

use App\Models\BlogPost;
use App\Models\User;

class BlogPostPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'formateur', 'student'], true);
    }

    public function view(User $user, BlogPost $post): bool
    {
        // Students can view published posts; admin/formateur can view all
        return $user->role !== 'student' || $post->status === 'published';
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'formateur'], true);
    }

    public function update(User $user, BlogPost $post): bool
    {
        return $user->role === 'admin' || ($user->role === 'formateur' && $post->user_id === $user->id);
    }

    public function delete(User $user, BlogPost $post): bool
    {
        return $user->role === 'admin' || ($user->role === 'formateur' && $post->user_id === $user->id);
    }
}
