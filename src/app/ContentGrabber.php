<?php

namespace App;

class ContentGrabber
{
    use CurlSourcer;
    use CanPdf;
    use CanZip;

    private static array $linksArray;
    private static int $numberOfPages;

    public static function getLinksArray(string $magazineUrl, int $numberOfPages): array
    {
        static::$numberOfPages = $numberOfPages;
        static::$linksArray = [];

        $extractedContent = static::getContent($magazineUrl);
        $publisher = (bool)preg_match("/issuu|isu\.pub/i", $extractedContent) !== false
            ? ['name' => 'ISSUU', 'referrer' => 'https://issuu.com']
            : ['name' => 'CALAMEO', 'referrer' => 'https://calameo.com'];
        $shortenedLink = dirname($extractedContent, 1) . "/";

        if ($publisher['name'] === 'ISSUU') {
            for ($i = 0; $i < static::$numberOfPages; $i++) {
                static::$linksArray[] = $shortenedLink . "page_" . ($i + 1) . ".jpg";
            }
        } else {
            for ($i = 0; $i < static::$numberOfPages; $i++) {
                static::$linksArray[] = $shortenedLink . "p" . ($i + 1) . ".jpg";
            }
        }
        return static::$linksArray;
    }


}