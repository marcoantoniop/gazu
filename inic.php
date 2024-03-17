<?php
// Iniciando la sesion
session_start();

// Incluyendo el archivo de idiomas

// Recuperando la configuraci�n de la base de datos
include_once(CONFIG_DIR_ABS . "/datos/conex.php");

include_once(CONFIG_DIR_ABS . "/datos/d_menu.php");
include_once(CONFIG_DIR_ABS . "/datos/usuario.php");
include_once(CONFIG_DIR_ABS . "/datos/acceso.php");

// Inicializando las Variables
include_once(CONFIG_DIR_ABS . "/componentes/temas/tema.php");
include_once(CONFIG_DIR_ABS . "/componentes/menus/menu.php");
include_once(CONFIG_DIR_ABS . "/componentes/menus/ClassMenu.php");

// Inicializando los objetos
//$Datos = new conex($Cfg_host, $Cfg_nombre_base, $Cfg_clave_base, $Cfg_nombre_usuario, $Cfg_base_prefijo);
$Datos = new conex();

$Tema = new tema();

$_SESSION['SaltarCuerpo'] = false;
 $_SESSION['SaltarMenu'] = false;
//  ARCHIVOS CSS BOOTSTRAP



// Cargando los archivos de funciones y otros
include_once(CONFIG_DIR_ABS . "/includes/fundamentales.php");
include_once(CONFIG_DIR_ABS . "/includes/temas.php");
// Incluyendo el archivo de temas
$D_tema = CONFIG_DIR_ABS . "/temas/" . $Tema->arch_tema;

include_once($D_tema . "/contenido.php");
// Parche de la direcci�n
$T_imagenes = $D_sitio_url . "/temas/" . $Tema->arch_tema . $T_imagenes;

foreach($T_encabezado as $encabezado) {
   include_once($D_tema . $encabezado);
}
foreach($T_cuerpo as $cuerpo) {
   include_once($D_tema . $cuerpo);
}
foreach($T_pie as $pie) {
   include_once($D_tema . $pie);
}



?>