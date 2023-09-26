<?php

namespace Swatty007\LaravelVersioningHelper\Console\Command;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use PHLAK\SemVer;

class VersioningHelper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'versioning:helper
        {--major= : Major Version}
        {--minor= : Minor Version}
        {--patch= : Patch Version}
        {--preRelease= : Pre-Release Version}
        {--build= : Build Version}

        {--incrementMajor : Increment Major Version}
        {--incrementMinor : Increment Minor Version}
        {--incrementPatch : Increment Patch Version}

        {--parse=true : Defines version should be parsed. (Automatically applies build & modification date from your versioning system) }
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Helper Command to set your applications version.';

    /**
     * Current Version.
     */
    public SemVer\Version $version;

    /**
     * Defines the modification date of our current revision.
     *
     * @var Carbon
     */
    public Carbon $modificationDate;

    /**
     * Defines the current PHP runtime at which our application runs.
     *
     * @var string
     */
    public string $runtime;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws SemVer\Exceptions\InvalidVersionException
     *
     * @return int
     */
    public function handle(): int
    {
        $this->version = new SemVer\Version();

        $currentVersion = Cache::pull(config('laravel-versioning-helper.version_key')) ?? Config::get(config('laravel-versioning-helper.version_key'));
        if ($currentVersion) {
            $this->version->setVersion($currentVersion);
        }

        $this->applyOptions();

        $this->info('Current Version: '.$currentVersion);
        $this->line('New Version: '.$this->version);

        $this->parseBuild();

        $this->saveVersion();

        return 0;
    }

    /**
     * Helper Method to apply our Commands Options.
     */
    private function applyOptions()
    {
        $options = $this->options();

        if (isset($options['major'])) {
            $this->version->setMajor($options['major']);
        }
        if (isset($options['minor'])) {
            $this->version->setMinor($options['minor']);
        }
        if (isset($options['patch'])) {
            $this->version->setPatch($options['patch']);
        }
        if (isset($options['preRelease'])) {
            $this->version->setPreRelease($options['preRelease']);
        }
        if (isset($options['build'])) {
            $this->version->setBuild($options['build']);
        }

        if ($options['incrementMajor']) {
            $this->version->incrementMajor();
        }
        if ($options['incrementMinor']) {
            $this->version->incrementMinor();
        }
        if ($options['incrementPatch']) {
            $this->version->incrementPatch();
        }
    }

    /**
     * Helper Method to assemble a version string based on our used repository system.
     */
    private function parseBuild()
    {
        $versioningSystem = config('laravel-versioning-helper.versioning_system');

        switch ($versioningSystem) {
            case 'git':
                // For git we can use the tag to receive our version number as fallback
                $currentVersion = config('laravel-versioning-helper.version') ?? exec('git describe --tags --abbrev=0');
                // And the latest hash as our revision Nr
                $revision = trim(exec('git log --pretty="%h" -n1 HEAD'));
                $modificationDate = Carbon::parse(trim(exec('git log -n1 --pretty=%ci HEAD')));
                break;
            case 'svn':
                // For SVN we have to take our version from our config & assume it was set by a build script!
                $currentVersion = config('laravel-versioning-helper.version');
                // and SVNs latest rev as our revision
                $revision = exec("svn info | grep 'Last Changed Rev' | awk '{ print $4; }'");
                $modificationDate = Carbon::parse(trim(exec("svn info | grep 'Last Changed Date' | awk '{ print $4 \" \" $5; }'")));
                break;
            case 'self-updater':
                $currentVersion = config('laravel-versioning-helper.version');
                $revision = '';
                $modificationDate = Carbon::parse(config('self-update.version_date'));
                break;
            default:
                $currentVersion = '0.0.0';
                $revision = '';
                $modificationDate = Carbon::now();
                break;
        }

        if ($modificationDate) {
            $this->modificationDate = $modificationDate;
        }

        if ($currentVersion && $this->options()['parse']) {
            $this->version->setVersion($currentVersion);
            $this->version->setBuild($revision);
        }

        if (!App::environment('production')) {
            $this->runtime = 'PHP v'.PHP_VERSION;
        }
    }

    /**
     * Helper Method to save our applications version within the system.
     */
    private function saveVersion()
    {
        Cache::put(config('laravel-versioning-helper.version_key'), $this->version);
        Cache::put(config('laravel-versioning-helper.modification_date_key'), $this->modificationDate);
        Cache::put(config('laravel-versioning-helper.runtime_key'), $this->runtime);
    }
}
