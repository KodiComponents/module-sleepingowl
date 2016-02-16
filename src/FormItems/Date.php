<?php

namespace KodiCMS\SleepingOwlAdmin\FormItems;

class Date extends BaseDateTime
{
    /**
     * @var string
     */
    protected $view = 'date';

    /**
     * @var string
     */
    protected $format = 'Y-m-d';
}
