<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use MartinCamen\RectorRules\SingleLineDocBlockRector;

return RectorConfig::configure()
    ->withConfiguredRule(SingleLineDocBlockRector::class, [
        SingleLineDocBlockRector::COLLAPSE_DESCRIPTIONS => true,
    ]);
