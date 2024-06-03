<?php

namespace App;

use ZipArchive;

trait CanZip
{
    use CanPdf;

    public $zip;

    public function zipFiles(string $magazinePath, string $uuid)
    {
        $zipPath = $magazinePath . '/' . $uuid . '.zip';
        $this->zip = new ZipArchive();
        $this->zip->open($zipPath, ZipArchive::CREATE);
        $this->zip->addEmptyDir('images');
        $files = scandir($magazinePath);
        $pdf = $this->pdfCreator();
        foreach ($files as $file) {
            if (is_file($magazinePath . '/' . $file)) {
                $this->zip->addFile($magazinePath . '/' . $file, 'images/' . $file);
                $pdf->AddPage();
                $pdf->Image($magazinePath . '/' . $file);
            }
        }
        $pdfContent = $pdf->Output($uuid , 'S');
        $this->zip->addFromString($uuid . '.pdf', $pdfContent);
        $this->zip->close();

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $uuid . '.zip');
        header('Content-Length: ' . filesize($zipPath));
        readfile($zipPath);
        unlink($zipPath);
        foreach (glob("*/$uuid/*") as $file) {
            unlink($file);
        }
        rmdir($magazinePath);
        unset($files, $uuid, $pdfContent);
        $this->zip = '';
        return;

    }
}