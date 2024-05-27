<?php

namespace AwStudio\Maillog;

use AwStudio\Maillog\Providers\EventServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MaillogServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'maillog');
    }

    /**
     * Boot the package service provider.
     *
     * @return void
     */
    public function boot()
    {
        if (! Config::has('logging.channels.maillog')) {
            Config::set(
                'logging.channels.maillog',
                [
                    'driver' => 'single',
                    'path' => storage_path('logs/maillog.log'),
                    'level' => 'info',
                ],
            );
        }

        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateMailLogsTable')) {
                $this->publishes([
                    __DIR__.'/../database/migrations/create_maillogs_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_maillogs_table.php'),
                ], 'migrations');
            }

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('maillog.php'),
            ], 'config');
        }
    }
}
