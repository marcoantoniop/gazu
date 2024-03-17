<?php include("includes/acceso.php"); ?>
<?php
require_once "componentes/pdocrud/script/pdocrud.php";
$pdocrud = new PDOCrud();
$pdocrud->setSettings("pagination", false);
$pdocrud->setSettings("searchbox", false);
$pdocrud->setSettings("deleteMultipleBtn", false);
$pdocrud->setSettings("recordsPerPageDropdown", false);
$pdocrud->setSettings("recordsPerPageDropdown", false);
$pdocrud->setSettings("totalRecordsInfo", true);
$pdocrud->setSettings("addbtn", true);
$pdocrud->setSettings("editbtn", false);
$pdocrud->setSettings("viewbtn", false);
$pdocrud->setSettings("delbtn", false);
$pdocrud->setSettings("actionbtn", false);
$pdocrud->setSettings("checkboxCol", false);
$pdocrud->setSettings("numberCol", false);
$pdocrud->setSettings("printBtn", false);
$pdocrud->setSettings("pdfBtn", false);
$pdocrud->setSettings("csvBtn", false);
$pdocrud->setSettings("excelBtn", false);

$pdocrud->crudTableCol(array('nombres','usuario','activo'));

$pdocrud->formFields(array('ci','nombres','ape_pat','ape_mat','genero'));

echo $pdocrud->dbTable("usuario")->render();