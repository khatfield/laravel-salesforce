<?php

namespace Khatfield\LaravelSalesforce;

use Illuminate\Support\ServiceProvider;

class SalesforceServiceProvider extends ServiceProvider
{
    protected $defer = true;

    protected $sf_client;

    public function register()
    {
        $config = __DIR__ . '/config/config.php';
        $this->mergeConfigFrom($config, 'salesforce');
        $this->publishes([$config => config_path('salesforce.php')]);

        $this->app->singleton('salesforce', function($app){
            $salesforce = new Salesforce();
            $salesforce->connect($app['config']);

            return $salesforce;
        });
    }

    public function provides()
    {
        return ['salesforce', 'Khatfield\LaravelSalesforce\Salesforce'];
    }
}