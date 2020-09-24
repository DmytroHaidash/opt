<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableActions extends Component
{
    /**
     * @var string
     */
    public $edit;

    /**
     * @var string|null
     */
    public $delete;

    /**
     * @var string|null
     */
    public $show;

    /**
     * Create a new component instance.
     *
     * @param string $edit
     * @param string|null $delete
     * @param string|null $show
     */
    public function __construct(string $edit = null, string $delete = null, string $show = null)
    {
        $this->edit = $edit;
        $this->delete = $delete;
        $this->show = $show;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.table-actions');
    }
}
