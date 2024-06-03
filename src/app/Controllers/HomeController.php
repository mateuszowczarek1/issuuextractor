<?php

namespace App\Controllers;

use App\InitializesTwig;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController
{
    use InitializesTwig;

    public function __construct()
    {
        $this->initializeTwig();
    }

    public function index(): void
    {
        echo $this->twig->render('index.html.twig', [
            'updates' => [
                [
                    'date' => '07.01.24',
                    'content' => 'Cześć 🐕 Od teraz można pobierać tym również czasopisma z Calameo. Wklejamy link i wpisujemy liczbę stron. Generujemy tabelę z linkami i pobieramy pdf. M.'
                ]
            ]
        ]);
    }
}
