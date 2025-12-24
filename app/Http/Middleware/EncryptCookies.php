<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        // Allow the XSRF cookie to be readable by client JS and the VerifyCsrfToken middleware
        'XSRF-TOKEN',
    ];
}
