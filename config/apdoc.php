<?php

return [

    'info' => [
        'title' => env('APP_NAME'),
        'version' => 'v0.0.1',
        'description' => env('APP_NAME')." API Documentation page",
    ],
 
    'path' => 'api-documentation',

    'enable_documentation' => true,

    'domain' => null,

    'middleware' => [
        'web',
    ],

    /*
     * output json file, location folder storage
     */
    'output' => 'api-docs',

    'servers' => [
        [
            'url' => 'https://saturn.crocodic.net/medco/public',
            'description' => 'DEV',
        ],
        [
            'url' => env('APP_URL', 'http://localhost'),
            'description' => 'LOCAL',
        ],
        [
            'url' => 'https://114.5.237.90/medco-sa/public',
            'description' => 'MEDCO',
        ],
    ],

    'security' => [
        'BearerAuth' => [
            'type' => 'http',
            'scheme' => 'bearer',
            'bearerFormat' => 'JWT',
        ],
    ],

    
    'api' =>[
        'path' => 'api/',
        'exclude' => [
            // 'api/index','api/store/{id}'
        ],

        // 'overview_information_view' => 'api-doc/overview',

        
        // 'response_code' => [
        //     "200" => "OKE",
        //     "401" => "Unauthorized",
        //     "400" => "Bad Request",
        //     "403" => "Forbidden",
        // ],
        // 'response_error' => [
        //     "invalid_token" => "token tidak sesuai : return logout",
        //     "expired_token" => "token expired : return logout atau renew token",
        //     "unauthorized" => "token tidak ditemukan : return logout",
        //     "forbidden" => "tidak memiliki akses url",
        // ],

    ],

    /**
     * Use with @defaultParam
     * key => [type,is_required,description,example]
     */
    'default_parameter' => [
        'headers' =>  [
            'platform' => ['string',true],
            'regid' => ['string',true],
        ]  
    ]

];
