<?php

namespace KodiCMS\SleepingOwlAdmin\Filter;

use Illuminate\Database\Eloquent\Builder;

class FilterScope extends FilterField
{
    /**
     * @param Builder $query
     */
    public function apply(Builder $query)
    {
        call_user_func([$query, $this->getName()], $this->getValue());
    }
}
