<?php
ini_set('memory_limit', '1024M');
set_time_limit(500);
require('../vendor/tecnickcom/tcpdf/tcpdf.php');
$uuid = uniqid();

$allowedExtensions = ['jpg', 'gif', 'png'];
$linksArray = [];
if (isset($_POST['links'])) {
    $linksArray = $_POST['links'];
} else {
    echo "No links were found.";
}

if (!file_exists($uuid)) {
    mkdir($uuid);
}

$dir = $uuid;

foreach ($linksArray as $key => $link) {
    $url = $link;
    $extension = substr($link, -3);
    $filename;

    if (($key + 1) < 10) {
        $filename = "000" . ($key + 1) . "." . $extension;
    } elseif (($key + 1) < 100) {
        $filename = "00" . ($key + 1) . "." . $extension;
    } elseif (($key + 1) < 1000) {
        $filename = "0" . ($key + 1) . "." . $extension;
    } else {
        $filename = ($key + 1) . "." . $extension;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3");
    curl_setopt($ch, CURLOPT_REFERER, $_POST['publisher']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $data = curl_exec($ch);
    curl_close($ch);
    file_put_contents($uuid .  "/" . $filename, $data);
};


$command = 'mogrify -format jpg -density 300 -units pixelsperinch -path "' . $dir . '" -define jpeg:preserve-settings -quality 100 -background white -alpha background -resample 300 "' . $dir . '/*.*"';
shell_exec($command);


$zipFilePath = __DIR__ . '/' . $uuid . '.zip';
$zip = new ZipArchive();
$zip->open($zipFilePath, ZipArchive::CREATE);
$zip->addEmptyDir('images');
$files = scandir($dir);
$pdf = new TCPDF();
foreach ($files as $file) {
    if (in_array(pathinfo($file, PATHINFO_EXTENSION), $allowedExtensions)) {
        $zip->addFile($dir . '/' . $file, 'images/' . $file);
        $pdf->AddPage();
        $pdf->Image($dir . '/' . $file);
    }
}

$pdfContent = $pdf->Output($uuid, 'S');
$zip->addFromString($uuid . '.pdf', $pdfContent);
$zip->close();




header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $uuid . '.zip"');
header('Content-Length: ' . filesize($zipFilePath));
readfile($zipFilePath);

unlink($zipFilePath);

foreach (glob("$uuid/*") as $file) {
    unlink($file);
}
rmdir($uuid);
unset($files, $uuid, $zip, $pdfContent);
