<?php

namespace Khatfield\LaravelSalesforce\Providers;

use Illuminate\Support\ServiceProvider;
use Khatfield\LaravelSalesforce\Salesforce;

class SalesforceServiceProvider extends ServiceProvider
{
    protected $defer = true;

    protected $sf_client;

    public function register()
    {
        $config = realpath(__DIR__ . '/..') . '/config/config.php';
        $this->mergeConfigFrom($config, 'salesforce');
        $this->publishes([$config => config_path('salesforce.php')]);

        $this->app->singleton(Salesforce::class, function($app)
        {
            $salesforce = new Salesforce();
            $salesforce->connect($app['config']);

            return $salesforce;
        });

        $this->app->alias(Salesforce::class, 'salesforce');
    }

    public function provides()
    {
        return ['salesforce', Salesforce::class];
    }

}