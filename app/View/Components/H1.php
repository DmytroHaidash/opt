<?php

namespace App\View\Components;

use Illuminate\View\Component;

class H1 extends Component
{
    /**
     * @var string
     */
    public $align;

    /**
     * Create a new component instance.
     *
     * @param string $align
     */
    public function __construct(string $align = 'center')
    {
        $this->align = $align;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.h1');
    }
}
