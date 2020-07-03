<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * @var Request
     */
    protected $request, $builder, $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     * @return mixed
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

       foreach ($this->getFilters() as $filter => $value) {
          if (method_exists($this, $filter)) {
              $this->$filter($value);
          }
       }

        return $this->builder;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        $filters = array_intersect(array_keys($this->request->all()), $this->filters);

        return $this->request->only($filters);
    }
}