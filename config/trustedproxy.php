<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies
    |--------------------------------------------------------------------------
    |
    | This configuration is used by the TrustProxies middleware to trust
    | the proxies that sit in front of the application (e.g. Railway's
    | edge proxy). Set to '*' to trust all proxies, which allows Laravel
    | to honor the X-Forwarded-* headers and generate https URLs.
    |
    */

    'proxies' => env('TRUSTED_PROXIES', '*'),

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxy Headers
    |--------------------------------------------------------------------------
    |
    | The headers that should be trusted from the proxies above. The
    | defaults already trust X-Forwarded-For, Host, Port, Proto and
    | Prefix headers, which is what this application needs.
    |
    */

    'headers' => Illuminate\Http\Request::HEADER_X_FORWARDED_FOR |
        Illuminate\Http\Request::HEADER_X_FORWARDED_HOST |
        Illuminate\Http\Request::HEADER_X_FORWARDED_PORT |
        Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO |
        Illuminate\Http\Request::HEADER_X_FORWARDED_PREFIX |
        Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB,

];