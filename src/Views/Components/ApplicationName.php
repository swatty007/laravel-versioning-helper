<?php

namespace Swatty007\LaravelVersioningHelper\Views\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ApplicationName extends Component
{
    /**
     * Defines the applications url
     *
     * @var string
     */
    public string $url;

    /**
     * Defines the applications name
     *
     * @var string
     */
    public string $name;

    /**
     * Create a new component instance.
     *
     * @param null $url
     * @param null $name
     */
    public function __construct($url=null, $name = null)
    {
        $this->url = $url ?? config('app.url');
        $this->name = $name ?? config('app.name');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('laravel-versioning-helper::components.application-name');
    }
}
