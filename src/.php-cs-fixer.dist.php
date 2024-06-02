<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude('vendor');

$config = new Config();
return $config
    ->setRules([
        '@PSR12' => true,
        'single_quote' => false, // Use double quotes
    ])
    ->setFinder($finder);
