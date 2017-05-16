<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'user*',
        'role*',
        'publication*',
        'committee*',
        'committee_member*',
        'member*',
        'committee_status*',
        'publication_status*'
    ];
}
