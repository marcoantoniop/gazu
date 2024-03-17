<?php
/**
 * Created by PhpStorm.
 * User: MARCOP
 * Date: 13/6/2019
 * Time: 09:39 PM
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_time_limit(500);
require("config.php");
require($D_sitio . "/inic.php");
if ($Cfg_offline == true) {
    include_once($D_sitio . "/offline.php");
    exit;
    exit();
    exit(0);
}
?>