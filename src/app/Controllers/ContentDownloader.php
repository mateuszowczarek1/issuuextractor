<?php

namespace App\Controllers;

use App\CanPdf;
use App\CanZip;
use App\ContentGrabber;

class ContentDownloader
{
    public static string $uuid;
    const string MAGAZINE_PATH = __DIR__ . '/../../public/files/magazine/';

    use CanPdf;
    use CanZip;

    public static function downloadPages(array $linksArray, array $allowedExtensions)
    {
        static::$uuid = static::idGenerator();
        $magazinePath = self::MAGAZINE_PATH . static::$uuid;

        if (!file_exists($magazinePath)) {
            mkdir($magazinePath);
        }

        foreach ($linksArray as $key => $link) {
            $extension = pathinfo($link, PATHINFO_EXTENSION);
            if (!in_array($extension, $allowedExtensions)) {
                continue;
            }
            $number = $key + 1;
            $filename = sprintf('%04d.%s', $number, $extension);
            file_put_contents($magazinePath . '/' . $filename, ContentGrabber::setCurl($link));
        }

        $command = 'mogrify -format jpg -density 300 -units pixelsperinch -path "' . $magazinePath . '" -define jpeg:preserve-settings -quality 100 -background white -alpha background -resample 300 "' . $magazinePath . '/*.*"';

        shell_exec($command);


        static::zipFiles($magazinePath, static::$uuid);
    }

    public static function idGenerator(): string
    {
        return uniqid('magazine');
    }
}