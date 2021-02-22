<?php

namespace Swatty007\LaravelVersioningHelper\Tests;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase;
use Swatty007\LaravelVersioningHelper\LaravelVersioningHelperServiceProvider;

class VersionHelperCommandTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LaravelVersioningHelperServiceProvider::class];
    }

    /** @test */
    public function can_set_major_version()
    {
        Cache::put('laravel-versioning-helper.version', "0.5.0");
        $this->artisan('versioning:helper', [
                '--major' => 1
            ])
            ->assertExitCode(0);

        $newVersion = Cache::pull('laravel-versioning-helper.version');
        $this->assertEquals("1.0.0", $newVersion);
    }

    /** @test */
    public function can_set_minor_version()
    {
        Cache::put('laravel-versioning-helper.version', "0.5.0");
        $this->artisan('versioning:helper', [
                '--minor' => 1
            ])
            ->assertExitCode(0);

        $newVersion = Cache::pull('laravel-versioning-helper.version');
        $this->assertEquals("0.1.0", $newVersion);
    }

    /** @test */
    public function can_set_patch_version()
    {
        Cache::put('laravel-versioning-helper.version', "0.5.0");
        $this->artisan('versioning:helper', [
                '--patch' => 1
            ])
            ->assertExitCode(0);

        $newVersion = Cache::pull('laravel-versioning-helper.version');
        $this->assertEquals("0.5.1", $newVersion);
    }

    /** @test */
    public function can_set_pre_release_version()
    {
        Cache::put('laravel-versioning-helper.version', "0.5.0");
        $this->artisan('versioning:helper', [
                '--preRelease' => 'alpha'
            ])
            ->assertExitCode(0);

        $newVersion = Cache::pull('laravel-versioning-helper.version');
        $this->assertEquals("0.5.0-alpha", $newVersion);
    }

    /** @test */
    public function can_set_build_version()
    {
        Cache::put('laravel-versioning-helper.version', "0.5.0");
        $this->artisan('versioning:helper', [
                '--build' => 1
            ])
            ->assertExitCode(0);

        $newVersion = Cache::pull('laravel-versioning-helper.version');
        $this->assertEquals("0.5.0+1", $newVersion);
    }

    /** @test */
    public function can_increment_major_version()
    {
        Cache::put('laravel-versioning-helper.version', "0.5.0");
        $this->artisan('versioning:helper', [
                '--incrementMajor' => true
            ])
            ->assertExitCode(0);

        $newVersion = Cache::pull('laravel-versioning-helper.version');
        $this->assertEquals("1.0.0", $newVersion);
    }

    /** @test */
    public function can_increment_minor_version()
    {
        Cache::put('laravel-versioning-helper.version', "0.5.0");
        $this->artisan('versioning:helper', [
                '--incrementMinor' => true
            ])
            ->assertExitCode(0);

        $newVersion = Cache::pull('laravel-versioning-helper.version');
        $this->assertEquals("0.6.0", $newVersion);
    }

    /** @test */
    public function can_increment_patch_version()
    {
        Cache::put('laravel-versioning-helper.version', "0.5.0");
        $this->artisan('versioning:helper', [
                '--incrementPatch' => true
            ])
            ->assertExitCode(0);

        $newVersion = Cache::pull('laravel-versioning-helper.version');
        $this->assertEquals("0.5.1", $newVersion);
    }

    /** @test */
    public function can_parse_svn_version()
    {
        Config::set('laravel-versioning-helper.versioning_system', 'svn');

        Cache::put('laravel-versioning-helper.version', "0.5.0");
        $this->artisan('versioning:helper', [
                '--parse' => true
            ])
            ->assertExitCode(0);

        $newVersion = Cache::pull('laravel-versioning-helper.version');
        $this->assertEquals("0.5.0", $newVersion);
    }

    /** @test */
    public function can_parse_git_version()
    {
        Config::set('laravel-versioning-helper.versioning_system', 'git');

        Cache::put('laravel-versioning-helper.version', "0.5.0");
        $this->artisan('versioning:helper', [
                '--parse' => true
            ])
            ->assertExitCode(0);

        $newVersion = Cache::pull('laravel-versioning-helper.version');
        $this->assertEquals("0.5.0", $newVersion);
    }

    /** @test */
    public function can_parse_self_updater_version()
    {
        Config::set('laravel-versioning-helper.versioning_system', 'self-updater');

        Cache::put('laravel-versioning-helper.version', "0.5.0");
        $this->artisan('versioning:helper', [
                '--parse' => true
            ])
            ->assertExitCode(0);

        $newVersion = Cache::pull('laravel-versioning-helper.version');
        $this->assertEquals("0.5.0", $newVersion);
    }

    /** @test */
    public function can_parser_has_fallback_version()
    {
        Config::set('laravel-versioning-helper.versioning_system', null);

        Cache::put('laravel-versioning-helper.version', "0.5.0");
        $this->artisan('versioning:helper', [
                '--parse' => true
            ])
            ->assertExitCode(0);

        $newVersion = Cache::pull('laravel-versioning-helper.version');
        $this->assertEquals("0.0.0", $newVersion);
    }
}
