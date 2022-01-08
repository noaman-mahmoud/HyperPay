<?php

return [

    /*
    |--------------------------------------------------------------------------
    | HyperPay Mode
    |--------------------------------------------------------------------------
    |
    | Mode only values: "test" or "live"
    |
    */

    "mode" => env( 'HYPER_PAY_MODE', "test" ),

    /*
    |--------------------------------------------------------------------------
    | HyperPay currency
    |--------------------------------------------------------------------------
    | EUR , SA , .. ets
    */

    "currency" => env( 'HYPER_CURRENCY', "EUR" ),

    /*
    |--------------------------------------------------------------------------
    | Access Token
    |--------------------------------------------------------------------------
    |
    | Your access token to enable integration with hyperpay
    |
    */

    "token" => env( 'HYPER_PAY_TOKEN', "OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=" ),

    /*
     |--------------------------------------------------------------------------
     | Brands [VisaMaster,StcPay,Mada,Amex,Apple] and entity Id's
     |--------------------------------------------------------------------------
     |
     | You must put entityId your own for each Brand
     |
     */

    'entities' => [

        'VisaMaster' => "8a8294174b7ecb28014b9699220015ca",
        'StcPay'     => "8a8294174b7ecb28014b9699220015ca",
        'mada'       => "8a8294174b7ecb28014b9699220015ca",
        'Amex'       => "8a8294174b7ecb28014b9699220015ca",
        'Apple'      => "",
    ],

    /*
     |--------------------------------------------------------------------------
     | information date
     |--------------------------------------------------------------------------
     | the information date required example street1,city,state .. etc
     |
     |
     */

    'information' => [

        'customer.givenName' => "noaman",
        'billing.postcode'   => "21955",
        'customer.surname'   => "noaman",
        'billing.street1'    => "Prince Badr bin Abdulaziz Street",
        'billing.country'    => "SA",
        'customer.email'     => "noaman@info.com",
        'billing.state'      => "Riyadh",
        'billing.city'       => "Riyadh",
    ]

];
