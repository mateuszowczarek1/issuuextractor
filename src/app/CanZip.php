<?php

namespace App;

use ZipArchive;

trait CanZip
{
    use CanPdf;

    public static $zip;

    public static function zipFiles(string $magazinePath, string $uuid)
    {
        $zipPath = $magazinePath . '/' . $uuid . '.zip';
        static::$zip = new ZipArchive();
        static::$zip->open($zipPath, ZipArchive::CREATE);
        static::$zip->addEmptyDir('images');
        $files = scandir($magazinePath);
        $pdf = static::pdfCreator();
        foreach ($files as $file) {
            if (is_file($magazinePath . '/' . $file)) {
                static::$zip->addFile($magazinePath . '/' . $file, 'images/' . $file);
                $pdf->AddPage();
                $pdf->Image($magazinePath . '/' . $file);
            }
        }
        $pdfContent = $pdf->Output($uuid, 'S');
        static::$zip->addFromString($uuid . '.pdf', $pdfContent);
        static::$zip->close();

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $uuid . '.zip');
        header('Content-Length: ' . filesize($zipPath));
        readfile($zipPath);
        unlink($zipPath);
        foreach (glob("$magazinePath/*") as $file) {
            unlink($file);
        }
        rmdir($magazinePath);
        unset($files, $uuid, $pdfContent);
        static::$zip = '';
        return;

    }
}
