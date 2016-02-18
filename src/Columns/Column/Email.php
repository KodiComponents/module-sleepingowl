<?php

namespace KodiCMS\SleepingOwlAdmin\Columns\Column;

class Email extends NamedColumn
{
    public function __construct($name)
    {
        parent::__construct($name);
        $this->setAttribute('class', 'row-email');
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return parent::toArray() + [
            'value'  => $this->getModelValue(),
            'append' => $this->getAppend(),
        ];
    }
}
