<?php
require_once "componentes/pdocrud/script/pdocrud.php";
$pdocrud = new PDOCrud();

$pdocrud->addFilter("elementos","Filtro por elementos","nombre_elemento","dropdown");
$pdocrud->setFilterSource("elementos","vista_elemento","id_control","nombre_elemento");



echo $pdocrud->dbTable("vista_elemento")->render();