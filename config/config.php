<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    /*
        |--------------------------------------------------------------------------
        | Author
        |--------------------------------------------------------------------------
        |
        | This option defines, the text which will be rendered as author within the copyright component
        |
        */
    'author' => 'Developed with ❤',

    /*
        |--------------------------------------------------------------------------
        | Author URL
        |--------------------------------------------------------------------------
        |
        | This option defines, to where our Author field within the copyright component will link to
        |
        */
    'author_url' => '',

    /*
        |--------------------------------------------------------------------------
        | Creation Date
        |--------------------------------------------------------------------------
        |
        | This option defines, the creation state of your application, which will be shown within the copyright component
        |
        */
    'creation_date' => '',

    /*
        |--------------------------------------------------------------------------
        | Show current date
        |--------------------------------------------------------------------------
        |
        | This option defines, if the copyright component should render the current date (Copyright FROM > TO, instead of a plain date)
        |
        */
    'show_current_date' => true,

    /*
        |--------------------------------------------------------------------------
        | Changelog URL
        |--------------------------------------------------------------------------
        |
        | This option defines the URL under which your applications changelog can be found
        |
        */
    'changelog_url' => '/changelog',

    /*
        |--------------------------------------------------------------------------
        | Versioning System
        |--------------------------------------------------------------------------
        |
        | This option defines, what versioning system your application is using (to determine your build/revision)
        |
        */
    'versioning_system' => 'svn',

    /*
        |--------------------------------------------------------------------------
        | Version
        |--------------------------------------------------------------------------
        |
        | This option defines, the current version of our application. You should set this either via your env file, or our supplied artisan commands!
        | Ideally you set those automatically within your deployment pipeline.
        |
        */
    'version' => env('APPLICATION_VERSION', ''),

    /*
        |--------------------------------------------------------------------------
        | Version Key
        |--------------------------------------------------------------------------
        |
        | This option defines, the Cache key, which is used to store our current application version.
        |
        */
    'version_key' => 'laravel-versioning-helper.version',

    /*
        |--------------------------------------------------------------------------
        | Modification Date Key
        |--------------------------------------------------------------------------
        |
        | This option defines, the Cache key, which is used to store our current version modification date.
        |
        */
    'modification_date_key' => 'laravel-versioning-helper.modification_date',

    /*
        |--------------------------------------------------------------------------
        | Runtime Key
        |--------------------------------------------------------------------------
        |
        | This option defines, the Cache key, which is used to store our current runtime.
        |
        */
    'runtime_key' => 'laravel-versioning-helper.runtime',
];
