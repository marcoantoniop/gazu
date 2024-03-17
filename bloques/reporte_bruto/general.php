<?php include("includes/acceso.php"); ?>
<?php
require_once "componentes/pdocrud/script/pdocrud.php";
$pdocrud = new PDOCrud();



$pdocrud->setSettings("totalRecordsInfo", true);
$pdocrud->setSettings("addbtn", true);
$pdocrud->setSettings("editbtn", false);

$pdocrud->setSettings("delbtn", false);
$pdocrud->setSettings("actionbtn", false);
$pdocrud->setSettings("checkboxCol", false);
$pdocrud->setSettings("numberCol", false);

//$pdocrud->addFilter("idCliente", "Cliente", "id_cliente", "dropdown");
//$pdocrud->setFilterSource("idCliente", "cliente", "id_cliente", "id_cliente as id_c", "db");

//$pdocrud->colRename("first_name", "client name");
//$pdocrud->crudTableCol(array("first_name","last_name"));
echo $pdocrud->dbTable("vista_ocr_bruto")->render();
?>