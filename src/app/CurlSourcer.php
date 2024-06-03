<?php

namespace App;

use DOMDocument;

trait CurlSourcer
{
    private $curl;
    private $dom;


    private function setCurl(?string $url)
    {
        if($url) {
            $this->magazineLink = $url;
        }
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_URL, $this->magazineLink);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');
        curl_setopt($this->curl, CURLOPT_REFERER, $this->magazineLink);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $response;
    }

    private function setDom()
    {
        $this->dom = new DOMDocument();
        @$this->dom->loadHTML($this->setCurl(null));
        return $this->dom->getElementsByTagName('meta');
    }

    private function getContent(): string
    {
        $metaTags = $this->setDom();
        foreach ($metaTags as $meta) {
            if ($meta->getAttribute('property') == 'og:image:secure_url') {
                return $meta->getAttribute('content');
            }
        }
        return '';
    }
}
