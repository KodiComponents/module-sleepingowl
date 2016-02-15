<?php

namespace KodiCMS\SleepingOwlAdmin\Display;

use Meta;
use Input;
use Route;
use Illuminate\Contracts\Support\Renderable;
use KodiCMS\SleepingOwlAdmin\Columns\Column;
use KodiCMS\SleepingOwlAdmin\Repository\TreeRepository;
use KodiCMS\SleepingOwlAdmin\Interfaces\DisplayInterface;
use KodiCMS\SleepingOwlAdmin\Interfaces\WithRoutesInterface;

class DisplayTree implements Renderable, DisplayInterface, WithRoutesInterface
{
    public static function registerRoutes()
    {
        Route::post('{adminModel}/reorder', function ($model) {
            $data = Input::get('data');
            $model->display()->repository()->reorder($data);
        });
    }

    /**
     * @var string
     */
    protected $class;

    /**
     * @var array
     */
    protected $with = [];

    /**
     * @var TreeRepository
     */
    protected $repository;

    /**
     * @var bool
     */
    protected $reorderable = true;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var string
     */
    protected $value = 'title';

    /**
     * @var string
     */
    protected $parentField = 'parent_id';

    /**
     * @var string
     */
    protected $orderField = 'order';

    /**
     * @var string|null
     */
    protected $rootParentId = null;

    public function initialize()
    {
        Meta::loadPackage(get_class());
        $this->repository = new TreeRepository($this->class);
        $this->repository->with($this->getWith());
        Column::treeControl()->initialize();
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        if (is_null($this->class)) {
            $this->class = $class;
        }
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getParentField()
    {
        return $this->parentField;
    }

    /**
     * @param string $parentField
     *
     * @return $this
     */
    public function setParentField($parentField)
    {
        $this->parentField = $parentField;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderField()
    {
        return $this->orderField;
    }

    /**
     * @param string $orderField
     */
    public function setOrderField($orderField)
    {
        $this->orderField = $orderField;
    }

    /**
     * @return null|string
     */
    public function getRootParentId()
    {
        return $this->rootParentId;
    }

    /**
     * @param null|string $rootParentId
     */
    public function setRootParentId($rootParentId)
    {
        $this->rootParentId = $rootParentId;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     *
     * @return $this
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getWith()
    {
        return $this->with;
    }

    /**
     * @param \string[] $with
     *
     * @return $this
     */
    public function setWith($with)
    {
        if (! is_array($with)) {
            $with = func_get_args();
        }
        $this->with = $with;

        return $this;
    }

    /**
     * @return bool
     */
    public function isReorderable()
    {
        return $this->reorderable;
    }

    /**
     * @param bool $reorderable
     */
    public function setReorderable($reorderable)
    {
        $this->reorderable = (bool) $reorderable;
    }

    /**
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return app('sleeping_owl.template')->view('display.tree', $this->getParams());
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $model = $this->getModel();

        return [
            'items'       => $this->getRepository()->getTree(),
            'reorderable' => $this->isReorderable(),
            'url'         => $model->getDisplayUrl(),
            'value'       => $this->getValue(),
            'creatable'   => ! is_null($model->create()),
            'createUrl'   => $model->createUrl($this->getParameters() + Input::all()),
            'controls'    => [Column::treeControl()],
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->render();
    }

    /**
     * @return TreeRepository
     */
    protected function getRepository()
    {
        $this->repository->parentField($this->getParentField());
        $this->repository->orderField($this->getOrderField());
        $this->repository->rootParentId($this->getRootParentId());

        return $this->repository;
    }

    /**
     * @return ModelConfiguration
     */
    protected function getModel()
    {
        return app('sleeping_owl')->getModel($this->class);
    }
}
