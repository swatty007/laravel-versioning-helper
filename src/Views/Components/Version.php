<?php

namespace Swatty007\LaravelVersioningHelper\Views\Components;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Version extends Component
{
    /**
     * Defines the modification date of our current revision.
     *
     * @var Carbon
     */
    public Carbon $modificationDate;

    /**
     * Defines the current version of our application.
     *
     * @var string
     */
    public string $version;

    /**
     * Defines the current PHP runtime at which our application runs.
     *
     * @var string
     */
    public string $runtime;

    /**
     * Defines the URL which contains our applications changelog.
     *
     * @var string|Application|UrlGenerator
     */
    public string $changelogURL;

    /**
     * Defines the full Version String of our build, its version number including our revision & runtime.
     *
     * @var string
     */
    public string $build;

    /**
     * Create a new component instance.
     *
     * @param null $changelogURL
     */
    public function __construct($changelogURL = null)
    {
        $this->changelogURL = url($changelogURL ?? config('laravel-versioning-helper.changelog_url'));
        $this->version = Cache::pull(config('laravel-versioning-helper.version_key')) ?? config(config('laravel-versioning-helper.version_key'));
        $this->modificationDate = Cache::pull(config('laravel-versioning-helper.modification_date_key')) ?? Carbon::now();

        $this->build = sprintf('v%s (%s)', $this->version, $this->modificationDate->format('d/m/y H:i'));
        if (!App::environment('production')) {
            $this->runtime = Cache::pull(config('laravel-versioning-helper.runtime_key')) ?? 'PHP v'.PHP_VERSION;
            $this->build .= " $this->runtime";
        } else {
            $this->runtime = '';
            $this->build = '';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('laravel-versioning-helper::components.version');
    }
}
