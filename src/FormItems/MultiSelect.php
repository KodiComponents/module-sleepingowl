<?php

namespace KodiCMS\SleepingOwlAdmin\FormItems;

use Input;
use Illuminate\Database\Eloquent\Collection;

class MultiSelect extends Select
{
    /**
     * @var string
     */
    protected $view = 'multiselect';

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name . '[]';
    }

    /**
     * @return array
     */
    public function getValue()
    {
        $value = parent::getValue();

        if ($value instanceof Collection && $value->count() > 0) {
            $value = $value->lists($value->first()->getKeyName());
        }
        if ($value instanceof Collection) {
            $value = $value->toArray();
        }

        return $value;
    }

    public function save()
    {
        $attribute = $this->getAttribute();

        if (is_null(Input::get($this->getPath()))) {
            $values = [];
        } else {
            $values = $this->getValue();
        }

        /** @var \Illuminate\Database\Eloquent\Relations\BelongsToMany $relation */
        $relation = $this->getModel()->{$attribute}();

        $relation->sync($values);
    }
}
