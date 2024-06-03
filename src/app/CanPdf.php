<?php

namespace App;

trait CanPdf
{
    public function pdfCreator(): \TCPDF
    {
        return new \TCPDF();
    }
}
