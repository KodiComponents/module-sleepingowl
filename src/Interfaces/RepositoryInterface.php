<?php

namespace KodiCMS\SleepingOwlAdmin\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

interface RepositoryInterface
{
    /**
     * @return Model
     */
    public function getModel();

    /**
     * @param Model $model
     */
    public function setModel(Model $model);

    /**
     * @return \string[]
     */
    public function getWith();

    /**
     * @param \string[] $with
     */
    public function setWith($with);

    /**
     * Get base query.
     * @return Builder
     */
    public function getQuery();

    /**
     * Find model instance by id.
     *
     * @param int $id
     *
     * @return Model|null
     */
    public function find($id);

    /**
     * Find model instances by ids.
     *
     * @param int[] $ids
     *
     * @return Model[]
     */
    public function findMany(array $ids);

    /**
     * Delete model instance by id.
     *
     * @param int $id
     */
    public function delete($id);

    /**
     * Restore model instance by id.
     *
     * @param int $id
     */
    public function restore($id);

    /**
     * Check if model's table has column.
     *
     * @param string $column
     *
     * @return bool
     */
    public function hasColumn($column);
}
