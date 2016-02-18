<?php

namespace KodiCMS\SleepingOwlAdmin\ColumnFilters;

use Illuminate\Database\Eloquent\Builder;
use KodiCMS\SleepingOwlAdmin\Interfaces\RepositoryInterface;
use KodiCMS\SleepingOwlAdmin\Interfaces\NamedColumnInterface;
use KodiCMS\SleepingOwlAdmin\Interfaces\ColumnFilterInterface;

class Range extends BaseColumnFilter
{
    /**
     * @var string
     */
    protected $view = 'range';

    /**
     * @var ColumnFilterInterface
     */
    protected $from;

    /**
     * @var ColumnFilterInterface
     */
    protected $to;

    /**
     * Initialize column filter.
     */
    public function initialize()
    {
        parent::initialize();

        $this->getFrom()->initialize();
        $this->getTo()->initialize();
    }

    /**
     * @return ColumnFilterInterface
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param ColumnFilterInterface $from
     *
     * @return $this
     */
    public function setFrom(ColumnFilterInterface $from)
    {
        $this->from = (int) $from;

        return $this;
    }

    /**
     * @return ColumnFilterInterface
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param ColumnFilterInterface $to
     *
     * @return $this
     */
    public function setTo(ColumnFilterInterface $to)
    {
        $this->to = (int) $to;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return parent::getParams() + [
            'from' => $this->getFrom(),
            'to'   => $this->getTo(),
        ];
    }

    /**
     * @param RepositoryInterface  $repository
     * @param NamedColumnInterface $column
     * @param Builder              $query
     * @param string               $search
     * @param array|string         $fullSearch
     * @param string               $operator
     *
     * @return void
     */
    public function apply(
        RepositoryInterface $repository,
        NamedColumnInterface $column,
        Builder $query,
        $search,
        $fullSearch,
        $operator = '='
    ) {
        $from = array_get($fullSearch, 'from');
        $to = array_get($fullSearch, 'to');

        if (! empty($from)) {
            $this->getFrom()->apply($repository, $column, $query, $from, $fullSearch, '>=');
        }

        if (! empty($to)) {
            $this->getTo()->apply($repository, $column, $query, $to, $fullSearch, '<=');
        }
    }
}
