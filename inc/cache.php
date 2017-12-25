<?php

use J0sh0nat0r\SimpleCache\Cache;
use J0sh0nat0r\SimpleCache\Drivers\File;
use J0sh0nat0r\SimpleCache\StaticFacade;

$GLOBALS['cache'] = new Cache(File::class, [
    'dir' => dirname(__DIR__).'/cache',
    'encryption_key' => $config->cacheEncryptionKey,
]);

StaticFacade::bind($GLOBALS['cache']);