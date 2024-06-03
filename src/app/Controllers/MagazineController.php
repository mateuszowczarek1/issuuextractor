<?php

namespace App\Controllers;

use App\CanPdf;
use App\CanZip;
use App\CurlSourcer;
use App\ContentGrabber;
use App\InitializesTwig;

class MagazineController
{
    use InitializesTwig;


    public function __construct()
    {
        $this->initializeTwig();
    }

    public function index(): void
    {
        // TODO: Error handling here

        $linksArray = ContentGrabber::getLinksArray($_POST['issuu-link'], $_POST['number-of-pages']);


        echo $this->twig->render('magazine/index.html.twig', ['linksArray' => $linksArray]);
    }

//    public function store()
//    {
//
//
//        $this->linksArray = json_decode($_POST['linksArray']);
//        $allowedExtensions = ['jpg', 'gif', 'png'];
//        $uuid = uniqid();
//        $magazinePath = __DIR__ . '/../../public/files/magazine/' . $uuid;
//
//        if (!file_exists($magazinePath)) {
//            mkdir($magazinePath);
//        }
//
//        foreach ($this->linksArray as $key => $link) {
//            $extension = pathinfo($link, PATHINFO_EXTENSION);
//            if (!in_array($extension, $allowedExtensions)) {
//                continue; // Skip processing if extension is not allowed
//            }
//            $number = $key + 1;
//            $filename = sprintf('%04d.%s', $number, $extension);
//            file_put_contents($magazinePath . '/' . $filename, $this->setCurl($link));
//        }
//
//        $command = 'mogrify -format jpg -density 300 -units pixelsperinch -path "' . $magazinePath . '" -define jpeg:preserve-settings -quality 100 -background white -alpha background -resample 300 "' . $magazinePath . '/*.*"';
//
//        shell_exec($command);
//
//
//        $this->zipFiles($magazinePath, $uuid);
//    }
}
