<?php
/**
 * This file is part of ruogoo.
 *
 * Created by HyanCat.
 *
 * Copyright (C) HyanCat. All rights reserved.
 */

namespace Ruogoo\Signature\Console;

use Illuminate\Console\Command;

class ClientRevoke extends Command
{
    protected $signature = 'client:revoke {--key=}';
    protected $description = 'Revoke client\'s key and secret.';

    public function fire(): void
    {
        $this->info('Not implement.');
    }
}
