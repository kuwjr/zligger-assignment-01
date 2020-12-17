<?php

require_once __DIR__ . '/vendor/autoload.php';

function createPDF($output){
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($output);
    $mpdf->Output('download.pdf','D');
}

?>