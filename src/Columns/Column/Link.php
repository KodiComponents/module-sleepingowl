<?php

namespace KodiCMS\SleepingOwlAdmin\Columns\Column;

class Link extends NamedColumn
{
    /**
     * @var array
     */
    protected $linkAttributes = [];

    /**
     * @param $name
     */
    public function __construct($name)
    {
        parent::__construct($name);
        $this->setAttribute('class', 'row-link');
    }

    /**
     * @return array
     */
    public function getLinkAttributes()
    {
        return $this->linkAttributes;
    }

    /**
     * @param array $linkAttributes
     */
    public function setLinkAttributes(array $linkAttributes)
    {
        $this->linkAttributes = $linkAttributes;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return parent::toArray() + [
            'value'          => $this->getModelValue(),
            'link'           => $this->getModelConfiguration()->getEditUrl($this->getModel()->getKey()),
            'append'         => $this->getAppend(),
            'linkAttributes' => $this->getLinkAttributes()
        ];
    }
}
