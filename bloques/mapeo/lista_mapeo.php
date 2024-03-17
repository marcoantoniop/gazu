<?php include("includes/acceso.php"); ?>
<?php

// Acceso a Datos

// Calculos y procesos

// Eventos Ajenos

// Eventos Propios

require_once "componentes/pdocrud/script/pdocrud.php";
$pdocrud = new PDOCrud();
$pdocrud->setSettings("deleteMultipleBtn", false);
$pdocrud->setSettings("totalRecordsInfo", true);
$pdocrud->setSettings("addbtn", false);
$pdocrud->setSettings("editbtn", true);
$pdocrud->setSettings("delbtn", true);
$pdocrud->setSettings("actionbtn", false);
$pdocrud->setSettings("checkboxCol", false);
$pdocrud->recordsPerPage(20);
$pdocrud->joinTable('acta_tipo_elemento','acta_tipo_elemento.id_te = acta_elemento.id_te','INNER JOIN');
echo $pdocrud->dbTable('acta_elemento')->render();
