<?php
	if($_SESSION['id']){
	define('TINYAJAX_PATH', 'componentes/ajax');
    @require_once(TINYAJAX_PATH . "/TinyAjax.php");
    
	if(isset($_GET['funcion'])){
		$ajax = new TinyAjax();
		include("includes/f_alarma.php");
		include("includes/" . $_GET['funcion'] . ".php");
	}else{
		$ajax = new TinyAjax();
		include("includes/f_alarma2.php");
		}
	 }
	// Archivo que verifica muchas cosas, con un temporizador llamado f_alarma
	
?>
<?php
	if(isset($_GET['funcion'])){
		$ajax->drawJavaScript();
	}
 ?>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $Cfg_nombre_sitio; ?></title>
<link rel='STYLESHEET' type='text/css' href='temas/azul/estilo.css' media="screen">
<link rel='STYLESHEET' type='text/css' href='temas/azul/imprimir.css' media='print'>
<link href='includes/ajax/default.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="temas/azul/sdmenu.css" />
<link href="imagenes/llave.gif" type="image/x-icon" rel="shortcut icon" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script type="text/javascript" src="componentes/menus/sdmenu.js"></script>
    <script src="componentes/dhtmlx/dhtmlx.js"></script>
    <link rel="stylesheet" type="text/css" href="componentes/dhtmlx/dhtmlx.css">
    <!--<script language="JavaScript" type="text/javascript" src="includes/validador/jaxWidgets_RuntimeEngine.js"></script>-->
<!--<script language="JavaScript" type="text/javascript" src="includes/validador/jaxWidgets_Library.js"></script>-->
<!--<script language="JavaScript" type="text/javascript" src="includes/validador/jaxWidgets_Validator.js"></script>-->

<SCRIPT LANGUAGE="JavaScript">
var intervalo = setInterval("ver_alarma()",30000);


function ir(url, tool, menu, loc, scroll, resize, status, left, top, width, height) {
OpenWin = this.open(url, "CtrlWindow", "toolbar=" + tool + ",menubar=" + menu + ",location=" + loc + ",scrollbars=" + scroll + ",resizable=" + resize + ",status=" + status + ",left=" + left + ",top=" + top + ",width=" + width + ",height=" + height);
}
</SCRIPT>
	<script type="text/javascript">
	// <![CDATA[
	var myMenu;
	window.onload = function() {
		myMenu = new SDMenu("my_menu");
		myMenu.init();
		
	};
	// ]]>
	</script>

</head>
<body>
<div id="main-title" style="color: white;"><h1 style="color: white">CONVERSOR DE ARCHIVOS PDF </h1></div>