<?php

namespace Tests;

use AwStudio\Maillog\MaillogServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    protected function setUp(): void
    {

        parent::setUp();

        // Publish the migration
        // Artisan::call('vendor:publish', [
        //     '--provider' => "AwStudio\Maillog\MaillogServiceProvider",
        //     '--tag' => 'migrations',
        // ]);

        // Run the migration
        // Artisan::call('migrate');
    }

    protected function getPackageProviders($app)
    {
        return [
            MaillogServiceProvider::class,
        ];
    }

    // protected function defineDatabaseMigrations()
    // {
    //     $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    // }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
        // import the CreatePostsTable class from the migration
        include_once __DIR__.'/../database/migrations/create_maillogs_table.php.stub';

        // run the up() method of that migration class
        (new \CreateMailLogsTable)->up();
    }
}
