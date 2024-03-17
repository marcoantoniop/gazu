<?php
	if($_SESSION['id']){
	define('TINYAJAX_PATH', 'componentes/ajax');
    @require_once(TINYAJAX_PATH . "/TinyAjax.php");
    
	if(isset($_GET['funcion'])){
		$ajax = new TinyAjax();
		//include("includes/f_alarma.php");
		include("includes/" . $_GET['funcion'] . ".php");
	}else{
		//$ajax = new TinyAjax();
		//include("includes/f_alarma2.php");
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
<!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<title><?php echo $Cfg_nombre_sitio; ?></title>
<!--<link rel='STYLESHEET' type='text/css' href='temas/azul/estilo.css' media="screen">-->
<!--<link rel='STYLESHEET' type='text/css' href='temas/azul/imprimir.css' media='print'>-->
<link href='includes/ajax/default.css' rel='stylesheet' type='text/css'>
<!--<link rel="stylesheet" type="text/css" href="temas/azul/sdmenu.css" />-->
<link href="imagenes/llave.gif" type="image/x-icon" rel="shortcut icon" />
<!--<script type="text/javascript" src="componentes/menus/sdmenu.js"></script>-->
<!--    <script src="componentes/dhtmlx/dhtmlx.js"></script>-->
    <link rel="stylesheet" type="text/css" href="componentes/dhtmlx/dhtmlx.css">
    <!--<script language="JavaScript" type="text/javascript" src="includes/validador/jaxWidgets_RuntimeEngine.js"></script>-->
<!--<script language="JavaScript" type="text/javascript" src="includes/validador/jaxWidgets_Library.js"></script>-->
<!--<script language="JavaScript" type="text/javascript" src="includes/validador/jaxWidgets_Validator.js"></script>-->
    <!-- Bootstrap core CSS -->
    <link href="componentes/kendo/styles/kendo.common.min.css" rel="stylesheet" type="text/css" />
    <link href="componentes/kendo/styles/kendo.default.min.css" rel="stylesheet" type="text/css" />


    <!-- Custom fonts for this template-->
    <link href="temas/sb/vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="temas/sb/css/sb-admin-2.min.css" rel="stylesheet">

    <?php
    if ($IconPicker){
    ?>
        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
        <!-- Bootstrap-Iconpicker -->
        <link rel="stylesheet" href="componentes/bootstrap-iconpicker/dist/css/bootstrap-iconpicker.min.css"/>
    <?php
    }
    ?>


<script language="JavaScript">
// var intervalo = setInterval("ver_alarma()",30000);


function ir(url, tool, menu, loc, scroll, resize, status, left, top, width, height) {
OpenWin = this.open(url, "CtrlWindow", "toolbar=" + tool + ",menubar=" + menu + ",location=" + loc + ",scrollbars=" + scroll + ",resizable=" + resize + ",status=" + status + ",left=" + left + ",top=" + top + ",width=" + width + ",height=" + height);
}
</script>

    <!-- Bootstrap core JavaScript-->
<!--    <script src="componentes/kendo/js/jquery.min.js"></script>-->

<!--    <script src="componentes/kendo/js/kendo.web.min.js"></script>-->


    <script src="temas/sb/vendor/jquery/jquery.min.js"></script>
    <script src="temas/sb/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="temas/sb/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="temas/sb/js/sb-admin-2.min.js"></script>
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper" data-pg-collapsed>