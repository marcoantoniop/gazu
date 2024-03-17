<?php include("includes/acceso.php"); ?>
<?php
// Acceso a Datos
include_once("datos/mensaje.php");
$Mensaje = new mensaje();
// Calculos y procesos

// Eventos Ajenos
if($_POST[enviar_mensaje]){
	$Mensaje->nuevo_mensaje($_POST['mensaje'],$_POST['usuarios'],$_POST['evaluados'],$_POST['asunto']);
}
// Eventos Propios
if($_POST[nuevo_mensaje]){
	include_once("bloques/mensajes/n_mensaje.php");
	exit();
}

if($_POST[borrar_mensaje]){
	if($_POST['id_mensaje']){
		$Mensaje->borrar_mensaje($_POST['id_mensaje']);
	}else{
		alerta("Por favor seleccione un mensaje");
	}
}

if($_POST[ver_mensaje]){
	if($_POST['id_mensaje']){
		include_once("bloques/mensajes/ver_mensaje.php");
		exit();
	}else{
		alerta("Por favor seleccione un mensaje");
	}
}

?>
<form name="form1" method="post" action="">
<fieldset><legend>Panel de Botones</legend>
<table width="80%" border="0" align="right" cellpadding="0" cellspacing="0">
    <tr>
      <th><input type="submit" name="nuevo_mensaje" value="Nuevo Mensaje" id="nuevo_mensaje"></th>
      <th><input type="submit" name="ver_mensaje" value="Ver Mensaje" id="ver_mensaje" /></th>
      <th><input type="submit" name="borrar_mensaje" value="Borrar Mensaje" id="borrar_mensaje" /></th>
    </tr>
  </table>
</fieldset>
  <br />
  <br>
  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><fieldset>
<legend>Mensajes</legend>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="3">Tiene: <?php echo $Mensaje->revisar_mensajes(); ?> nuevo(s) mensaje(s)</td>
            </tr>
            <?php for($i=0; $i<$Mensaje->num_filas; $i++){ ?>
            <tr>
              <td><input type="radio" name="id_mensaje" id="radio" value="<?php echo $Mensaje->datos[$i]->id_mensaje;
              ?>" /></td>
              <td>
              <?php
              	if($Mensaje->datos[$i]->estado == 'N'){
              		echo "<strong>" . $Mensaje->datos[$i]->asunto . " -> " . $Mensaje->datos[$i]->nombres . " " . $Mensaje->datos[$i]->ape_pat . " " . $Mensaje->datos[$i]->ape_mat . "</strong>";
              	}else{
              		echo  $Mensaje->datos[$i]->asunto . " -> " . $Mensaje->datos[$i]->nombres . " " . $Mensaje->datos[$i]->ape_pat . " " . $Mensaje->datos[$i]->ape_mat;
              	}
              ?>
              
              </td>
              <td><?php echo $Mensaje->datos[$i]->hora; ?></td>
            </tr>
            <?php } ?>
          </table>
      </fieldset></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
