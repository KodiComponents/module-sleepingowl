<?php

namespace KodiCMS\SleepingOwlAdmin\Interfaces;

use Illuminate\Contracts\Support\Arrayable;

interface DisplayInterface extends Arrayable
{
    /**
     * Initialize display.
     */
    public function initialize();

    /**
     * Set display class.
     *
     * @param string $class
     */
    public function setClass($class);

    /**
     * @return array
     */
    public function getParams();
}
