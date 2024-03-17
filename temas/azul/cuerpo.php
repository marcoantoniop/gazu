<script language="JavaScript" type="text/javascript" src="includes/menudeclarations.js"></script>
<div id="main-text">
  <?php echo Mostrar_cuerpo(); ?>
</div>

<div id="bloque-fecha">
<?php echo Mostrar_bloque_fecha(); ?>
<?php
	echo "<br>" . Mostrar_usuario();
?>
</div>

<?php
if(isset($_GET['me'])){ 
	if($_GET['me'] == 0){
		exit();
	}
	}	

?>

<!--<div id="left-menu">-->
<div style="float: left" id="my_menu" class="sdmenu">
<?php echo Mostrar_menu(0,'primero'); ?>
</div>