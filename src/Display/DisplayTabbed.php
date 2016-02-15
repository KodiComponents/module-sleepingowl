<?php

namespace KodiCMS\SleepingOwlAdmin\Display;

use Closure;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Validation\Validator;
use KodiCMS\SleepingOwlAdmin\Interfaces\FormInterface;
use KodiCMS\SleepingOwlAdmin\Model\ModelConfiguration;
use KodiCMS\SleepingOwlAdmin\Interfaces\DisplayInterface;

class DisplayTabbed implements Renderable, DisplayInterface, FormInterface
{
    /**
     * Added tabs.
     * @var DisplayTab[]
     */
    protected $tabs = [];

    public function initialize()
    {
        foreach ($this->getTabs() as $tab) {
            if ($tab instanceof DisplayInterface) {
                $tab->initialize();
            }
        }
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        foreach ($this->getTabs() as $tab) {
            if ($tab instanceof DisplayInterface) {
                $tab->setClass($class);
            }
        }
    }

    /**
     * @return DisplayTab[]
     */
    public function getTabs()
    {
        return $this->tabs;
    }

    /**
     * @param Closure|DisplayTab[] $tabs
     *
     * @return $this
     */
    public function setTabs($tabs)
    {
        if (is_callable($tabs)) {
            $tabs = call_user_func($tabs, $this);
        }

        if (is_array($tabs)) {
            $this->tabs = $tabs;
        }

        return $this;
    }

    /**
     * @param DisplayInterface $display
     * @param string           $label
     * @param bool|false       $active
     *
     * @return $this
     */
    public function appendDisplay(DisplayInterface $display, $label, $active = false)
    {
        $tab = \SleepingOwlDisplay::tab($display)
            ->setLabel($label)
            ->setActive($active);

        $this->tabs[] = $tab;

        return $tab;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        foreach ($this->getTabs() as $tab) {
            if ($tab instanceof FormInterface) {
                $tab->setAction($action);
            }
        }
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        foreach ($this->getTabs() as $tab) {
            if ($tab instanceof FormInterface) {
                $tab->setId($id);
            }
        }
    }

    /**
     * @param ModelConfiguration $model
     *
     * @return Validator|null
     */
    public function validate(ModelConfiguration $model)
    {
        foreach ($this->getTabs() as $tab) {
            if ($tab instanceof FormInterface) {
                $result = $tab->validate($model);
                if (! is_null($result)) {
                    return $result;
                }
            }
        }

        return;
    }

    /**
     * @param ModelConfiguration $model
     */
    public function save(ModelConfiguration $model)
    {
        foreach ($this->getTabs() as $tab) {
            if ($tab instanceof FormInterface) {
                $tab->save($model);
            }
        }
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return [
            'tabs' => $this->getTabs(),
        ];
    }

    /**
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return app('sleeping_owl.template')->view('display.tabbed', $this->getParams());
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->render();
    }
}
