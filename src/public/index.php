<?php

require __DIR__ . '/../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

echo $twig->render('index.html.twig', [
    'updates' => [
        [
            'date' => '07.01.24',
            'content' => 'Cześć 🐕 Od teraz można pobierać tym również czasopisma z Calameo. Wklejamy link i wpisujemy liczbę stron. Generujemy tabelę z linkami i pobieramy pdf. M.'
        ]
    ]
]);
