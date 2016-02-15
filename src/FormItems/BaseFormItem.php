<?php

namespace KodiCMS\SleepingOwlAdmin\FormItems;

use Meta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Renderable;
use KodiCMS\SleepingOwlAdmin\Interfaces\FormItemInterface;

abstract class BaseFormItem implements Renderable, FormItemInterface, Arrayable
{
    /**
     * @var string
     */
    protected $view;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $validationRules = [];

    public function initialize()
    {
        Meta::loadPackage(get_class());
    }

    /**
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param Model $model
     *
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return array
     */
    public function getValidationRules()
    {
        return $this->validationRules;
    }

    /**
     * @param array|string $validationRules
     *
     * @return $this
     */
    public function setValidationRules($validationRules)
    {
        if (! is_array($validationRules)) {
            $validationRules = func_get_args();
        }
        foreach ($validationRules as $rule) {
            $validationRules[] = explode('|', $rule);
        }
        $this->validationRules = $validationRules;

        return $this;
    }

    /**
     * @param string $rule
     *
     * @return $this
     */
    public function addValidationRule($rule)
    {
        $this->validationRules[] = $rule;

        return $this;
    }

    public function save()
    {
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return [
            'model' => $this->getModel(),
        ];
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getParams();
    }

    /**
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return app('sleeping_owl.template')
            ->view('formitem.'.$this->getView(), $this->getParams())
            ->render();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->render();
    }
}
