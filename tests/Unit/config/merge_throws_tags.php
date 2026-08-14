<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use MartinCamen\RectorRules\MergeThrowsTagsRector;

return RectorConfig::configure()
    ->withRules([MergeThrowsTagsRector::class]);
