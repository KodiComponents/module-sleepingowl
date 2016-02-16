<?php

namespace KodiCMS\SleepingOwlAdmin\Columns\Column;

class Control extends BaseColumn
{
    /**
     * Column view.
     * @var string
     */
    protected $view = 'control';

    /**
     * @var string
     */
    protected $width = '50px';

    public function __construct()
    {
        parent::__construct();
        $this->setOrderable(false);
    }

    /**
     * @return mixed
     */
    protected function getModelKey()
    {
        return $this->getModel()->getKey();
    }

    /**
     * Check if instance supports soft-deletes and trashed.
     * @return bool
     */
    protected function isTrashed()
    {
        if (method_exists($this->getModel(), 'trashed')) {
            return $this->getModel()->trashed();
        }

        return false;
    }

    /**
     * Check if instance editable.
     * @return bool
     */
    protected function isEditable()
    {
        return ! $this->isTrashed() && ! is_null($this->getModelConfiguration()->fireEdit($this->getModelKey()));
    }

    /**
     * Get instance edit url.
     * @return string
     */
    protected function getEditUrl()
    {
        return $this->getModelConfiguration()->getEditUrl($this->getModelKey());
    }

    /**
     * Check if instance is deletable.
     * @return bool
     */
    protected function isDeletable()
    {
        return ! $this->isTrashed() && ! is_null($this->getModelConfiguration()->fireDelete($this->getModelKey()));
    }

    /**
     * Get instance delete url.
     * @return string
     */
    protected function getDeleteUrl()
    {
        return $this->getModelConfiguration()->getDeleteUrl($this->getModelKey());
    }

    /**
     * Check if instance is restorable.
     * @return bool
     */
    protected function isRestorable()
    {
        return $this->isTrashed() && ! is_null($this->getModelConfiguration()->fireRestore($this->getModelKey()));
    }

    /**
     * Get instance restore url.
     * @return string
     */
    protected function getRestoreUrl()
    {
        return $this->getModelConfiguration()->getRestoreUrl($this->getModelKey());
    }

    /**
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return app('sleeping_owl.template')->view('column.'.$this->view, [
            'editable'   => $this->isEditable(),
            'editUrl'    => $this->getEditUrl(),
            'deletable'  => $this->isDeletable(),
            'deleteUrl'  => $this->getDeleteUrl(),
            'restorable' => $this->isRestorable(),
            'restoreUrl' => $this->getRestoreUrl(),
        ]);
    }
}
