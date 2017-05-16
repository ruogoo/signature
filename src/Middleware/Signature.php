<?php
/**
 * This file is part of ruogoo.
 *
 * Created by HyanCat.
 *
 * Copyright (C) HyanCat. All rights reserved.
 */

namespace Ruogoo\Signature\Middleware;

use Closure;
use Ruogoo\Signature\Exception\SignatureException;
use Ruogoo\Signature\SignatureInterface;

class Signature
{
    public function handle($request, Closure $next)
    {
        if (! env('API_SIGNATURE', false)) {
            return $next($request);
        }
        $passed = app(SignatureInterface::class)->validate($request);
        if ($passed) {
            return $next($request);
        }

        throw new SignatureException();
    }
}
