<?php

namespace App;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

trait InitializesTwig
{
    private $twig;

    protected function initializeTwig()
    {
        if (!$this->twig) {
            $loader = new FilesystemLoader(__DIR__ . '/../templates');
            $this->twig = new Environment($loader);
        }
        return $this->twig;
    }
}