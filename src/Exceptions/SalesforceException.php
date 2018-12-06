<?php


namespace Khatfield\LaravelSalesforce\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class SalesforceException extends Exception
{
    public function report()
    {
        $channel = env('SALESFORCE_LOG_CHANNEL', 'daily');
        Log::channel($channel)->error($this->getMessage());
    }
}