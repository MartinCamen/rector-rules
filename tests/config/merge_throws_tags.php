<?php

declare(strict_types=1);

use MartinCamen\RectorRules\MergeThrowsTagsRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withRules([MergeThrowsTagsRector::class]);
