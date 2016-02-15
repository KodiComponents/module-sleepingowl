<?php

namespace KodiCMS\SleepingOwlAdmin\Columns\Column;

use KodiCMS\Support\Traits\HtmlAttributes;

class Link extends NamedColumn
{
    use HtmlAttributes;

    /**
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return app('sleeping_owl.template')->view('column.link', [
            'value'      => $this->getModelValue(),
            'link'       => $this->getModelConfiguration()->getEditUrl($this->getModel()->getKey()),
            'append'     => $this->getAppend(),
            'attributes' => $this->getAttributes(),
        ]);
    }
}
