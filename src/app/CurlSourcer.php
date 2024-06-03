<?php

namespace App;

use DOMDocument;

trait CurlSourcer
{
    private static $curl;
    private static $dom;

    private static string $url;


    private static function setCurl()
    {
        static::$curl = curl_init();
        curl_setopt(static::$curl, CURLOPT_URL, static::$url);
        curl_setopt(static::$curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt(static::$curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(static::$curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');
        curl_setopt(static::$curl, CURLOPT_REFERER, static::$url);
        curl_setopt(static::$curl, CURLOPT_TIMEOUT, 10);
        $response = curl_exec(static::$curl);
        curl_close(static::$curl);
        return $response;
    }

    private static function setDom()
    {
        static::$dom = new DOMDocument();
        @static::$dom->loadHTML(static::setCurl(static::$url));
        return static::$dom->getElementsByTagName('meta');
    }

    private static function getContent(string $url): string
    {
        static::$url = $url;

        $metaTags = static::setDom();
        foreach ($metaTags as $meta) {
            if ($meta->getAttribute('property') == 'og:image:secure_url') {
                return $meta->getAttribute('content');
            }
        }
        return '';
    }
}
