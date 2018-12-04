<?php

return [
    'username'        => env('SALESFORCE_USERNAME'),
    'password'        => env('SALESFORCE_PASSWORD'),
    'token'           => env('SALESFORCE_TOKEN'),
    'connection_type' => env('SALESFORCE_CONNECTION_TYPE'),
    'wsdl'            => storage_path('app/' . env('SALESFORCE_WSDL', 'wsdl/enterprise.wsdl.xml')),
];