<?php

namespace Khatfield\LaravelSalesforce;

use Khatfield\SoapClient\ClientBuilder;

/**
 * Class Salesforce
 * @package Khatfield\LaravelSalesforce
 */
class Salesforce
{
    public $client;

    public function __construct()
    {

    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->client, $method], $args);
    }

    /**
     * @param \Illuminate\Support\Collection $external_config
     * @throws SalesforceException
     */
    public function connect($external_config)
    {
        $user = $external_config->get('salesforce.username');
        $pass = $external_config->get('salesforce.password');
        $token = $external_config->get('salesforce.token');
        $conn_type  = $external_config->get('salesforce.connection_type');
        $wsdl = $external_config->get('salesforce.wsdl');
        if(empty($wsdl)){
            $wsdl = __DIR__ . '/wsdl/enterprise.wsdl.xml';
        }

        try{
            if($conn_type == 'partner'){
                $type = ClientBuilder::PARTNER;
            } else {
                $type = ClientBuilder::ENTERPRISE;
            }
            $builder = new ClientBuilder($wsdl, $user, $pass, $token);
            $this->client = $builder->build($type);
        } catch(\Exception $e){
            throw new SalesforceException('Exception at Constructor' . $e->getMessage() . "\n\n" . $e->getTraceAsString());
        }

    }

}