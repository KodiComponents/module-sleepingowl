<?php

namespace KodiCMS\SleepingOwlAdmin\Columns\Column;

use Meta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Renderable;
use KodiCMS\SleepingOwlAdmin\Model\ModelConfiguration;
use KodiCMS\SleepingOwlAdmin\Interfaces\ColumnInterface;

abstract class BaseColumn implements Renderable, ColumnInterface
{
    /**
     * Column header.
     * @var ColumnHeader
     */
    protected $header;

    /**
     * Model instance currently rendering.
     * @var Model
     */
    protected $model;

    /**
     * Column appendant.
     * @var ColumnInterface
     */
    protected $append;

    /**
     * @var
     */
    protected $width = null;

    public function __construct()
    {
        $this->header = new ColumnHeader;
    }

    /**
     * Initialize column.
     */
    public function initialize()
    {
        Meta::loadPackage(get_class());
    }

    /**
     * @return ColumnHeader
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param string $width
     *
     * @return $this
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return ColumnInterface
     */
    public function getAppend()
    {
        return $this->append;
    }

    /**
     * @param ColumnInterface $append
     *
     * @return $this
     */
    public function setAppend(ColumnInterface $append)
    {
        $this->append = $append;

        return $this;
    }

    /**
     * @return Model $model
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
        $append = $this->getAppend();
        if (! is_null($append) && ($append instanceof ColumnInterface)) {
            $append->setModel($model);
        }

        return $this;
    }

    /**
     * Get related model configuration.
     * @return ModelConfiguration
     */
    protected function getModelConfiguration()
    {
        return app('sleeping_owl')->getModel(get_class($this->getModel()));
    }

    /**
     * Set column header label.
     *
     * @param string $title
     *
     * @return $this
     */
    public function setLabel($title)
    {
        $this->header->setTitle($title);

        return $this;
    }

    /**
     * @param bool $orderable
     *
     * @return $this
     */
    public function setOrderable($orderable)
    {
        $this->header->setOrderable($orderable);

        return $this;
    }

    /**
     * Check if column is orderable.
     * @return bool
     */
    public function isOrderable()
    {
        return $this->header()->isOrderable();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->render();
    }
}
