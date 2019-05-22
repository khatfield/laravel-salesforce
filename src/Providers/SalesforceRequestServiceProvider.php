<?php


namespace Khatfield\LaravelSalesforce\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Khatfield\SoapClient\Result\SObject;

class SalesforceRequestServiceProvider extends ServiceProvider
{
    public function register()
    {
        //register request macros
        Request::macro('isSalesforce', function()
        {
            $is_xml = (strtolower($this->getContentType()) == 'xml');

            return ($is_xml && stripos($this->getContent(), 'sforce'));
        });

        Request::macro('salesforce', function()
        {
            $return  = new SObject();
            $content = $this->getContent();

            if($this->isSalesforce() && !empty($content)) {
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
                    foreach($sobject as $field => $value) {
                        $return->$field = (string) $value;
                    }
                }
            }

            return $return;
        });
    }

}