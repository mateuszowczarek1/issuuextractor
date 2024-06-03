<?php

namespace App\Controllers;

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

    public function store()
    {
        // TODO: Error handling here

        ContentDownloader::downloadPages(json_decode($_POST['linksArray']), ['jpg', 'gif', 'png']);

        return;
    }
}
