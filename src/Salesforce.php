<?php

namespace Khatfield\LaravelSalesforce;

use Khatfield\SoapClient\ClientBuilder;
use Khatfield\LaravelSalesforce\Exceptions\SalesforceException;
use Khatfield\SoapClient\Header\CallOptions;
use Khatfield\SoapClient\Result\SObject;

/**
 * Class Salesforce
 * @package Khatfield\LaravelSalesforce
 */
class Salesforce
{
    public $client;

    public function __call($method, $args)
    {
        return call_user_func_array([$this->client, $method], $args);
    }

    /**
     * @param \Illuminate\Support\Collection $external_config
     *
     * @throws SalesforceException
     */
    public function connect($external_config)
    {
        $user      = $external_config->get('salesforce.username');
        $pass      = $external_config->get('salesforce.password');
        $token     = $external_config->get('salesforce.token');
        $conn_type = $external_config->get('salesforce.connection_type');
        $wsdl      = $external_config->get('salesforce.wsdl');
        $name      = $external_config->get('salesforce.app_name');
        $version   = $external_config->get('app.version');

        if(empty($wsdl)) {
            $wsdl = realpath(__DIR__ . '/../resources') . '/wsdl/enterprise.wsdl.xml';
        }

        try {
            if($conn_type == 'partner') {
                $type = ClientBuilder::PARTNER;
                $name = $name . '/' . $version;
            } else {
                $type = ClientBuilder::ENTERPRISE;
            }
            $builder      = new ClientBuilder($wsdl, $user, $pass, $token);
            $this->client = $builder->build($type);
            if($conn_type == 'partner'){
                $this->client->addHeader(new CallOptions($name));
            }
        } catch(\Exception $e) {
            throw new SalesforceException('Exception at Constructor' . $e->getMessage() . "\n\n" . $e->getTraceAsString());
        }

    }

    /**
     * @param string $message
     *
     * @return SObject
     */
    protected function readInbound($message)
    {
        $message = trim($message);
        $sobject = null;
        $return  = new SObject();

        try {
            $xml     = simplexml_load_string($message);
            $body    = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')
                ->Body->children('http://soap.sforce.com/2005/09/outbound');
            $sobject = $body->notifications->Notification->sObject->children('urn:sobject.enterprise.soap.sforce.com');

        } catch(\Exception $e) {
            $error = new SalesforceException('Error getting Salesforce POST: ' . $e->getMessage(), $e->getCode(), $e);
            report($error);
            $sobject = false;
        }

        if(is_object($sobject)) {
            foreach($sobject as $field => $value){
                $return->$field = $value;
            }
        }

        return $return;
    }

    /**
     * Get the standard XML Acknowledgement response
     *
     * @return false|string
     */
    public function getResponse()
    {
        return file_get_contents(realpath(__DIR__ . '/../resources') . '/xml/response.xml');
    }
}