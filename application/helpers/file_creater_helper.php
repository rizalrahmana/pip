<?php


function xcreate_excel($namaFile) {
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // header untuk nama file
    header("Content-Disposition: attachment; filename=" . $namaFile . "");
    header("Content-Transfer-Encoding: binary ");
}


function xcreate_pdf($nama_file, $html, $kertas, $tipe_kertas) {

	$dompdf = new Dompdf\Dompdf();
	$dompdf->loadHtml($html);
    $dompdf->setPaper($kertas, $tipe_kertas);

    // Render the HTML as PDF
    $dompdf->render();

    // Get the generated PDF file contents
    $pdf = $dompdf->output();

    // Output the generated PDF to Browser
    $dompdf->stream($nama_file);
}



?>