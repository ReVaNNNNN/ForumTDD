<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular'];
    /**
     * @param string $username
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function by(string $username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    protected function popular()
    {
        return $this->builder->reorder('replies_count', 'desc');
    }
}