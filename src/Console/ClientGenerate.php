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
use Ruogoo\Signature\Model\AppClient;

class ClientGenerate extends Command
{
    protected $signature = 'client:generate {--name=}';
    protected $description = 'Generate client\'s key and secret.';

    public function fire(): void
    {
        $name = $this->option('name');
        if (null === $name) {
            $this->error('This console must has \'--name\' option.');
        }

        do {
            $key   = str_random(10);
            $exist = AppClient::where('key', $key)->exists();
        } while ($exist);
        $secret = str_random(32);

        AppClient::create([
            'name'   => $name,
            'key'    => $key,
            'secret' => $secret,
        ]);
        $this->info('Generated a new app client:');
        $this->info("name:$name\t key:$key" . "\t secret:$secret");
    }
}
