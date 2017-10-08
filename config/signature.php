<?php
/**
 * This file is part of ruogoo.
 *
 * Created by HyanCat.
 *
 * Copyright (C) HyanCat. All rights reserved.
 */

return [

    /**
     * A switch of signature.
     * If false, it will not check any request with valid signature or not.
     */
    'enabled' => env('API_SIGNATURE', false),

    /**
     * The field name in header.
     */
    'header' => 'X-SIGNATURE',

    /**
     * The hash algorithm for signature.
     */
    'hash_algorithm' => 'sha256',
];
