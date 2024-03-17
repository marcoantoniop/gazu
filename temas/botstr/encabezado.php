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
<!--<link rel='STYLESHEET' type='text/css' href='temas/azul/estilo.css' media="screen">-->
<!--<link rel='STYLESHEET' type='text/css' href='temas/azul/imprimir.css' media='print'>-->
<link href='includes/ajax/default.css' rel='stylesheet' type='text/css'>
<!--<link rel="stylesheet" type="text/css" href="temas/azul/sdmenu.css" />-->
<link href="imagenes/llave.gif" type="image/x-icon" rel="shortcut icon" />
<script type="text/javascript" src="componentes/menus/sdmenu.js"></script>
    <script src="componentes/dhtmlx/dhtmlx.js"></script>
    <link rel="stylesheet" type="text/css" href="componentes/dhtmlx/dhtmlx.css">
    <!--<script language="JavaScript" type="text/javascript" src="includes/validador/jaxWidgets_RuntimeEngine.js"></script>-->
<!--<script language="JavaScript" type="text/javascript" src="includes/validador/jaxWidgets_Library.js"></script>-->
<!--<script language="JavaScript" type="text/javascript" src="includes/validador/jaxWidgets_Validator.js"></script>-->
    <!-- Bootstrap core CSS -->
    <link href="temas/botstr/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="temas/botstr/dashboard.css" rel="stylesheet">
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
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">NUEVO SISTEMA BOOTSTRAP</a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="#">Sign out</a>
        </li>
    </ul>
</nav>