<?php

return [
    'username'        => env('SALESFORCE_USERNAME'),
    'password'        => env('SALESFORCE_PASSWORD'),
    'token'           => env('SALESFORCE_TOKEN'),
    'connection_type' => env('SALESFORCE_CONNECTION_TYPE'),
    'app_name'        => env('SALESFORCE_APP_NAME', env('APP_NAME', 'Laravel')),
    'wsdl'            => storage_path('app/wsdl/' . env('SALESFORCE_WSDL', 'enterprise.wsdl.xml')),
];