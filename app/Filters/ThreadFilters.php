<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ThreadFilters
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Builder
     */
    private $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        if ($this->request->has('by')) {
            $this->by($this->request->by);
        }

        return $this->builder;
    }

    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }
}