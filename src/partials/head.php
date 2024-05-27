<?php
$path = '../styles/bootstrap.min.css';
$pathLoader = '../styles/loader.css';

$head = <<<HEAD

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ISSUU and Calameo Downloader</title>
<link rel="stylesheet" type="text/css" href="$path">
<link rel="stylesheet" type="text/css" href="$pathLoader">

HEAD;

echo $head;
