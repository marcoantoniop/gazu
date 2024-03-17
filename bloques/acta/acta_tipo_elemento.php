<?php include("includes/acceso.php"); ?>
<?php

// Acceso a Datos

// Calculos y procesos

// Eventos Ajenos

// Eventos Propios

require_once "componentes/pdocrud/script/pdocrud.php";
$pdocrud = new PDOCrud();
//$pdocrud->setSettings("pagination", false);
$pdocrud->setSettings("searchbox", false);
$pdocrud->setSettings("deleteMultipleBtn", false);
//$pdocrud->setSettings("recordsPerPageDropdown", false);
//$pdocrud->setSettings("recordsPerPageDropdown", false);
$pdocrud->setSettings("totalRecordsInfo", true);
$pdocrud->setSettings("addbtn", true);
$pdocrud->setSettings("editbtn", true);
$pdocrud->setSettings("viewbtn", false);
$pdocrud->setSettings("delbtn", true);
$pdocrud->setSettings("actionbtn", true);
$pdocrud->setSettings("checkboxCol", false);
//$pdocrud->setSettings("numberCol", false);
$pdocrud->setSettings("printBtn", false);
$pdocrud->setSettings("pdfBtn", false);
$pdocrud->setSettings("csvBtn", false);
$pdocrud->setSettings("excelBtn", false);
$pdocrud->recordsPerPage(20);

$pdocrud->crudTableCol(array('nombre'));

$pdocrud->formFields(array('nombre'));

echo $pdocrud->dbTable("acta_tipo_elemento")->render();
?>
