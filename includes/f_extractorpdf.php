<?php
    /**
     * Created by PhpStorm.
     * User: MARCOP
     * Date: 24/6/2019
     * Time: 01:39 AM
     */
    //include("../componentes/ajax/TinyAjax.php");
    /**
     * Primero creamos la función a usar
     * @example function evento($params){}
     */
    function extraer_archivo_pdf($archivo, $carpeta){
        //include_once ('componentes/PdfToText/PdfToText.php');
        include_once "componentes/extractorpdf/ClassExtractorArchivo.php";
        $res = new TinyAjaxBehavior();

        $decodificaPdf = new ClassExtractorArchivo();
        $decodificaPdf->archivo = $archivo;
        $decodificaPdf->carpeta = $carpeta;
        $decodificaPdf->extraerArchivo();
        //$resultado = $decodificaPdf->devolverTabla();
        $resultado = $decodificaPdf->devolverCsv();
        /*
        $pdf = new PdfToText();

        $pdf->Separator = "----";
        $pdf->BlockSeparator = ";;;;";
        $miArchivoo = "adjuntos/" . $carpeta . "/" . $archivo;
        $pdf->Load($miArchivoo);
        $miCadena = $pdf->Text;
        $miCadenaArreglo = explode(";;;;",$miCadena);
        $lim = sizeof($miCadenaArreglo);
        $resultado = "";
        for($i = 0; $i < $lim; $i++){
            $resultado = $resultado . $i . " --> " . $miCadenaArreglo[$i] . "<br>";
        }
        */


        $res->add(TabInnerHtmlAppend::getBehavior("div_pdfprocesado",$resultado));
        //$res->add(TabInnerHtmlAppend::getBehavior("div_pdfprocesado","<hr>"));

        //    $res->add(TabAlert::getBehavior("Mensaje Nuevo"));
        //    $res->add(TabAlert::getBehavior("Al parece es urgente, mejor checalo..!!!"));
        //    $res->add(TabRedirect::getBehavior("?menu=f033ab37c30201f73f142449d037028d"));


            //$res->add(TabAlert::getBehavior("Sin mensajes"));

        return $res->getString();
    }

$ajax = new TinyAjax();
$ajax->exportFunction("extraer_archivo_pdf",array("archivo","carpeta"));
$ajax->process();
$ajax->drawJavaScript();
