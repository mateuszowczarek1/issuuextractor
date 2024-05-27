
<?php
    function getSource($magazineLink)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $magazineLink);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');

        $response = curl_exec($curl);

        curl_close($curl);

        $dom = new DOMDocument();
        @$dom->loadHTML($response);
        $metaTags = $dom->getElementsByTagName('meta');

        foreach ($metaTags as $meta) {
            if ($meta->getAttribute('property') == 'og:image:secure_url') {
                return $meta->getAttribute('content');
            }
        }

        return null;
    }
