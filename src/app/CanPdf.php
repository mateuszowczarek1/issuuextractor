<?php

namespace App;

trait CanPdf
{
    public static function pdfCreator(): \TCPDF
    {
        return new \TCPDF();
    }
}
