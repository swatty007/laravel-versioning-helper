<?php

namespace Swatty007\LaravelVersioningHelper\Views\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Copyright extends Component
{
    /**
     * Defines the applications author/company/vendor what ever it is ;)
     *
     * @var string
     */
    public string $author;

    /**
     * Supplies a link to our authors website
     *
     * @var string
     */
    public string $authorURL;

    /**
     * Defines the "start" date for our copyright notice
     *
     * @var string
     */
    public string $startDate;

    /**
     * Defines the "end" date for our copyright notice
     *
     * @var string
     */
    public string $endDate;
    /**
     * Defines the date string for our copyright notice
     *
     * @var string
     */
    public string $dates;

    /**
     * Create a new component instance.
     *
     * @param null $author
     * @param null $url
     * @param null $startDate
     * @param null $endDate
     */
    public function __construct($author = null, $url = null, $startDate = null, $endDate = null)
    {
        $this->author = $author ?? config('laravel-versioning-helper.author');
        $this->authorURL = $url  ?? config('laravel-versioning-helper.author_url');
        $this->startDate = $startDate ?? config('laravel-versioning-helper.creation_date');
        $this->endDate = $endDate ?? date('Y');

        if (config('laravel-versioning-helper.show_current_date')) {
            $this->dates = "$this->startDate - $this->endDate";
        } else {
            $this->dates = $this->endDate;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('laravel-versioning-helper::components.copyright');
    }
}
