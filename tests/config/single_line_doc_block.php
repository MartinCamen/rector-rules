<?php

declare(strict_types=1);

use MartinCamen\RectorRules\SingleLineDocBlockRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withRules([SingleLineDocBlockRector::class]);
