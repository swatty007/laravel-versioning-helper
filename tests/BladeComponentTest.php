<?php

namespace Swatty007\LaravelVersioningHelper\Tests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Swatty007\LaravelVersioningHelper\LaravelVersioningHelperServiceProvider;
use Swatty007\LaravelVersioningHelper\Views\Components\ApplicationName;
use Swatty007\LaravelVersioningHelper\Views\Components\BuildString;
use Swatty007\LaravelVersioningHelper\Views\Components\Copyright;
use Swatty007\LaravelVersioningHelper\Views\Components\Version;

class BladeComponentTest extends ComponentTestCase
{
    protected function getPackageProviders($app)
    {
        return [LaravelVersioningHelperServiceProvider::class];
    }

    /** @test */
    public function application_name_is_loaded()
    {
        $this->assertTrue(class_exists('Swatty007\LaravelVersioningHelper\Views\Components\ApplicationName'));
        $this->assertTrue(View::exists('laravel-versioning-helper::components.application-name'));

        $aliases = Blade::getClassComponentAliases();
        $this->assertTrue(isset($aliases['versioning-helper-application-name']));
    }

    /** @test */
    public function application_name_does_render()
    {
        $expected = <<<HTML
<span>
    <a href="http://localhost" target="_self" class="text-primary dim no-underline">Laravel</a>
</span>
HTML;
        $compiled = $this->rendered(ApplicationName::class);

        $this->assertSame($expected, $compiled);
    }

    /** @test */
    public function build_string_is_loaded()
    {
        $this->assertTrue(class_exists('Swatty007\LaravelVersioningHelper\Views\Components\BuildString'));
        $this->assertTrue(View::exists('laravel-versioning-helper::components.build-string'));

        $aliases = Blade::getClassComponentAliases();
        $this->assertTrue(isset($aliases['versioning-helper-build-string']));
    }

    /** @test */
    public function build_string_does_render()
    {
        $date = Carbon::now()->format('d/m/y H:i');
        $phpVersion = PHP_VERSION;

        $expected = <<<HTML
<div>
    <p class="text-center text-xs text-80">

        <span>
    <a href="http://localhost" target="_self" class="text-primary dim no-underline">Laravel</a>
</span>


        <span class="px-1">&middot;</span>
        <span>
    &copy;  - 2021 <a href="" target="_blank" class="text-primary dim no-underline">Developed with ❤</a>
</span>

        <span class="px-1">&middot;</span>
        <span>
    <a href="http://localhost/changelog" target="_blank" class="text-primary dim no-underline">v ($date) PHP v$phpVersion</a>
</span>

    </p>
</div>
HTML;
        $compiled = $this->rendered(BuildString::class);

        $this->assertSame($expected, $compiled);
    }

    /** @test */
    public function copyright_is_loaded()
    {
        $this->assertTrue(class_exists('Swatty007\LaravelVersioningHelper\Views\Components\Copyright'));
        $this->assertTrue(View::exists('laravel-versioning-helper::components.copyright'));

        $aliases = Blade::getClassComponentAliases();
        $this->assertTrue(isset($aliases['versioning-helper-copyright']));
    }

    /** @test */
    public function copyright_does_render()
    {
        $expected = <<<HTML
<span>
    &copy;  - 2021 <a href="" target="_blank" class="text-primary dim no-underline">Developed with ❤</a>
</span>
HTML;
        $compiled = $this->rendered(Copyright::class);

        $this->assertSame($expected, $compiled);
    }

    /** @test */
    public function version_is_loaded()
    {
        $this->assertTrue(class_exists('Swatty007\LaravelVersioningHelper\Views\Components\Version'));
        $this->assertTrue(View::exists('laravel-versioning-helper::components.version'));

        $aliases = Blade::getClassComponentAliases();
        $this->assertTrue(isset($aliases['versioning-helper-version']));
    }

    /** @test */
    public function version_does_render()
    {
        $date = Carbon::now();
        $dateString = $date->format('d/m/y H:i');
        $phpVersion = 'PHP v' . PHP_VERSION;

        Cache::put('laravel-versioning-helper.version', '0.0.1');
        Cache::put('laravel-versioning-helper.modificationDate', $date);
        Cache::put('laravel-versioning-helper.runTime', $phpVersion);

        $expected = <<<HTML
<span>
    <a href="http://localhost/changelog" target="_blank" class="text-primary dim no-underline">v0.0.1 ($dateString) $phpVersion</a>
</span>
HTML;
        $compiled = $this->rendered(Version::class);

        $this->assertSame($expected, $compiled);
    }
}
