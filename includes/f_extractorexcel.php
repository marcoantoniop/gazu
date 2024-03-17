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
    function extraer_archivo_xlsx($archivo, $carpeta){
        //include_once ('componentes/PdfToText/PdfToText.php');
        include_once "componentes/extractorexcel/ClassExtractorArchivoExcel.php";
        $res = new TinyAjaxBehavior();

        $decodifica = new ClassExtractorArchivoExcel();
        $decodifica->archivo = $archivo;
        $decodifica->carpeta = $carpeta;
        $resultado = $decodifica->extraerArchivo();

        $res->add(TabInnerHtmlAppend::getBehavior("div_xlsxprocesado",$resultado));
        return $res->getString();
    }

    function extraer_archivo_xlsx_sql($archivo, $carpeta){
        //include_once ('componentes/PdfToText/PdfToText.php');
        include_once "componentes/extractorexcel/ClassExtractorArchivoExcel.php";
        $res = new TinyAjaxBehavior();

        $decodifica = new ClassExtractorArchivoExcel();
        $decodifica->archivo = $archivo;
        $decodifica->carpeta = $carpeta;
        $resultado = $decodifica->extraerArchivoSQL();

        $res->add(TabInnerHtmlAppend::getBehavior("div_xlsxprocesado",$resultado));
        return $res->getString();
    }

    function extraer_archivo_comparar($archivo, $carpeta){
        //include_once ('componentes/PdfToText/PdfToText.php');
        include_once "componentes/extractorexcel/ClassExtractorArchivoExcel.php";
        $res = new TinyAjaxBehavior();

        $decodifica = new ClassExtractorArchivoExcel();
        $decodifica->archivo = $archivo;
        $decodifica->carpeta = $carpeta;
        $resultado = $decodifica->extraerArchivoComparar();
        $erro_sql = $decodifica->error_sql;

        $res->add(TabInnerHtmlAppend::getBehavior("div_xlsxprocesado",$resultado));
        $res->add(TabInnerHtmlAppend::getBehavior("div_error_sql",$erro_sql));
        return $res->getString();
    }

    function mostrarEspera(){
        $res = new TinyAjaxBehavior();
        $resultado = "--- ESPERE POR FAVOR - PROCESANDO ";
        $res->add(TabInnerHtml::getBehavior("div_espera",$resultado));


        return $res->getString();
    }

    function cerrarEspera(){
        $res = new TinyAjaxBehavior();
        $resultado = "--- PROCESO TERMINADO ";
        $res->add(TabInnerHtml::getBehavior("div_espera",$resultado));


        return $res->getString();
    }



$ajax = new TinyAjax();
$ajax->exportFunction("extraer_archivo_xlsx",array("archivo","carpeta"));
$ajax->exportFunction("extraer_archivo_xlsx_sql",array("archivo","carpeta"));
$ajax->exportFunction("extraer_archivo_comparar",array("archivo","carpeta"));
$ajax->exportFunction("mostrarEspera",array());
$ajax->exportFunction("cerrarEspera",array());

$ajax->process();
$ajax->drawJavaScript();
