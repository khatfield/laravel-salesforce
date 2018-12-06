<?php

namespace Khatfield\LaravelSalesforce\Providers;

use Illuminate\Support\ServiceProvider;
use Khatfield\SoapClient\Result\SObject;
use Khatfield\LaravelSalesforce\Salesforce;
use Illuminate\Http\Request;

class SalesforceServiceProvider extends ServiceProvider
{
    protected $defer = true;

    protected $sf_client;

    public function register()
    {
        //register request macro
        Request::macro('isSalesforce', function(){
            $is_xml = (strtolower($this->getContentType()) == 'xml');

            return ($is_xml && stripos($this->getContent(), 'sforce'));
        });

        Request::macro('salesforce', function(){
            $return  = new SObject();
            $content = $this->getContent();

            if($this->isSalesforce() && !empty($content)){
                $sobject = null;

                try {
                    $xml     = simplexml_load_string($content);
                    $body    = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')
                        ->Body->children('http://soap.sforce.com/2005/09/outbound');
                    $sobject = $body->notifications->Notification->sObject->children('urn:sobject.enterprise.soap.sforce.com');

                } catch(\Exception $e) {
                    $error = new \Khatfield\LaravelSalesforce\Exceptions\SalesforceException('Error getting Salesforce POST: ' . $e->getMessage(), $e->getCode(), $e);
                    report($error);
                    $sobject = false;
                }

                if(is_object($sobject)) {
                    foreach($sobject as $field => $value){
                        $return->$field = $value;
                    }
                }
            }

            return $return;
        });

        $config = __DIR__ . '/config/config.php';
        $this->mergeConfigFrom($config, 'salesforce');
        $this->publishes([$config => config_path('salesforce.php')]);

        $this->app->singleton(Salesforce::class, function($app){
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