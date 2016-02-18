<?php

namespace KodiCMS\SleepingOwlAdmin\Columns\Column;

class Filter extends NamedColumn
{
    /**
     * Filter related model.
     * @var string
     */
    protected $relatedModel;

    /**
     * Field to get filter value from.
     * @var string
     */
    protected $field;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->setAttribute('class', 'row-filter');
    }

    /**
     * @return string
     */
    public function getRelatedModel()
    {
        if (is_null($this->relatedModel)) {
            $this->setModel(get_class($this->getModel()));
        }

        return $this->relatedModel;
    }

    /**
     * @param string $relatedModel
     */
    public function setRelatedModel($relatedModel)
    {
        $this->relatedModel = $relatedModel;
    }

    /**
     * @return string
     */
    public function getField()
    {
        if (is_null($this->field)) {
            $this->setField($this->isSelf() ? $this->getName() : 'id');
        }

        return $this->field;
    }

    /**
     * @param string $field
     *
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get filter url.
     * @return string
     */
    public function getUrl()
    {
        $value = $this->getValue($this->getModel(), $this->getField());

        return app('sleeping_owl')->getModel($this->relatedModel)->getDisplayUrl([$this->getName() => $value]);
    }

    /**
     * Check if filter applies to the current model.
     * @return bool
     */
    protected function isSelf()
    {
        return get_class($this->getModel()) == $this->getRelatedModel();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return parent::toArray() + [
            'icon'  => $this->isSelf() ? 'fa-filter' : 'fa-arrow-circle-o-right',
            'title' => $this->isSelf() ? trans('sleepingowl::core.table.filter') : trans('sleepingowl::core.table.filter-goto'),
            'url'   => $this->getUrl(),
            'value' => $this->getValue($this->getModel(), $this->getField()),
        ];
    }
}
