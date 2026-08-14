<?php

declare(strict_types=1);

use MartinCamen\RectorRules\SingleLineDocBlockRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withConfiguredRule(SingleLineDocBlockRector::class, [
        SingleLineDocBlockRector::MAX_LINE_LENGTH => 60,
    ]);
