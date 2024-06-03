<?php

namespace App\Controllers;

use App\CanPdf;
use App\CanZip;
use App\CurlSourcer;
use App\InitializesTwig;

class MagazineController
{
    use CurlSourcer;
    use InitializesTwig;
    use CanZip;

    public bool $publisher;
    public array $linksArray;

    public string $magazineLink;

    public int $numberOfPages;

    public function __construct()
    {
        $this->initializeTwig();
    }

    public function index(): void
    {
        $this->magazineLink = $_POST['issuu-link'];
        $this->numberOfPages = $_POST['number-of-pages'];


        $this->linksArray = [];
        $extractedLink = $this->getContent();
        $publisher = (bool)preg_match("/issuu|isu\.pub/i", $extractedLink) !== false
            ? ['name' => 'ISSUU', 'referrer' => 'https://issuu.com']
            : ['name' => 'CALAMEO', 'referrer' => 'https://calameo.com'];
        $shortenedLink = dirname($extractedLink, 1) . "/";

        if ($publisher['name'] === 'ISSUU') {
            for ($i = 0; $i < $this->numberOfPages; $i++) {
                $this->linksArray[] = $shortenedLink . "page_" . ($i + 1) . ".jpg";
            }
        } else {
            for ($i = 0; $i < $this->numberOfPages; $i++) {
                $this->linksArray[] = $shortenedLink . "p" . ($i + 1) . ".jpg";
            }
        }
        echo $this->twig->render('magazine/index.html.twig', ['linksArray' => $this->linksArray]);
    }

    public function store()
    {
        $this->linksArray = json_decode($_POST['linksArray']);
        $allowedExtensions = ['jpg', 'gif', 'png'];
        $uuid = uniqid();
        $magazinePath = __DIR__ . '/../../public/files/magazine/' . $uuid;

        if (!file_exists($magazinePath)) {
            mkdir($magazinePath);
        }

        foreach ($this->linksArray as $key => $link) {
            $extension = pathinfo($link, PATHINFO_EXTENSION);
            if (!in_array($extension, $allowedExtensions)) {
                continue; // Skip processing if extension is not allowed
            }
            $number = $key + 1;
            $filename = sprintf('%04d.%s', $number, $extension);
            file_put_contents($magazinePath . '/' . $filename, $this->setCurl($link));
        }

        $command = 'mogrify -format jpg -density 300 -units pixelsperinch -path "' . $magazinePath . '" -define jpeg:preserve-settings -quality 100 -background white -alpha background -resample 300 "' . $magazinePath . '/*.*"';

        shell_exec($command);



        $this->zipFiles($magazinePath, $uuid);

    }
}
