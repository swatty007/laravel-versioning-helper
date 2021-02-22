<?php

namespace Swatty007\LaravelVersioningHelper\Views\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BuildString extends Component
{
    public $linkClasses;

    /**
     * Create a new component instance.
     *
     * @param $linkClasses
     */
    public function __construct($linkClasses = null)
    {
        $this->linkClasses = $linkClasses;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('laravel-versioning-helper::components.build-string');
    }
}
