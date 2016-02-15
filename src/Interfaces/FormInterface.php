<?php

namespace KodiCMS\SleepingOwlAdmin\Interfaces;

use Illuminate\Contracts\Validation\Validator;
use KodiCMS\SleepingOwlAdmin\Model\ModelConfiguration;

interface FormInterface
{
    /**
     * Set form action url.
     *
     * @param string $action
     */
    public function setAction($action);

    /**
     * Set form model instance id.
     *
     * @param int $id
     */
    public function setId($id);

    /**
     * @param ModelConfiguration $model
     *
     * @return Validator|null
     */
    public function validate(ModelConfiguration $model);

    /**
     * Save model.
     *
     * @param ModelConfiguration $model
     */
    public function save(ModelConfiguration $model);
}
