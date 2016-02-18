<?php

namespace KodiCMS\SleepingOwlAdmin\Columns\Column;

use Route;
use KodiCMS\SleepingOwlAdmin\Interfaces\WithRoutesInterface;

class Order extends BaseColumn implements WithRoutesInterface
{
    /**
     * Register routes.
     */
    public static function registerRoutes()
    {
        Route::post('{adminModel}/{adminModelId}/up', [
            'as' => 'admin.model.move-up',
            function ($model, $id) {
                $instance = $model->getRepository()->find($id);
                $instance->moveUp();

                return back();
            },
        ]);

        Route::post('{adminModel}/{adminModelId}/down', [
            'as' => 'admin.model.move-down',
            function ($model, $id) {
                $instance = $model->getRepository()->find($id);
                $instance->moveDown();

                return back();
            },
        ]);
    }

    public function __construct()
    {
        parent::__construct();
        $this->setAttribute('class', 'row-order');
    }

    /**
     * Get order value from instance.
     * @return int
     */
    protected function getOrderValue()
    {
        return $this->getModel()->getOrderValue();
    }

    /**
     * Get models total count.
     * @return int
     */
    protected function totalCount()
    {
        return $this->getModelConfiguration()->getRepository()->getQuery()->count();
    }

    /**
     * Check if instance is movable up.
     * @return bool
     */
    protected function movableUp()
    {
        return $this->getOrderValue() > 0;
    }

    /**
     * Get instance move up url.
     * @return Route
     */
    protected function moveUpUrl()
    {
        return route('admin.model.move-up', [
            $this->getModelConfiguration()->getAlias(),
            $this->getModel()->getKey(),
        ]);
    }

    /**
     * Check if instance is movable down.
     * @return bool
     */
    protected function movableDown()
    {
        return $this->getOrderValue() < $this->totalCount() - 1;
    }

    /**
     * Get instance move down url.
     * @return Route
     */
    protected function moveDownUrl()
    {
        return route('admin.model.move-down', [
            $this->getModelConfiguration()->getAlias(),
            $this->getModel()->getKey(),
        ]);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return parent::toArray() + [
            'movableUp'   => $this->movableUp(),
            'moveUpUrl'   => $this->moveUpUrl(),
            'movableDown' => $this->movableDown(),
            'moveDownUrl' => $this->moveDownUrl(),
        ];
    }
}
