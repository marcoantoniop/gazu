<?php include("includes/acceso.php"); ?>
<?php
// Acceso a Datos

// Calculos y procesos

// Eventos Ajenos

// Eventos Propios
$Mensaje->ver_mensaje($_POST['id_mensaje']);
?>
<form name="form1" method="post" action="">
<fieldset><legend>Panel de Botones</legend>
<table width="80%" border="0" align="right" cellpadding="0" cellspacing="0">
    <tr>
      <th><input name="id_mensaje" type="hidden" id="id_mensaje" value="<?php echo $Mensaje->datos[0]->id_mensaje; ?>"
          /></th>
      <th><input type="submit" name="cancelar" value="Regresar" id="cancelar"></th>
      <th><input name="borrar_mensaje" type="submit" id="borrar_mensaje" value="Borrar Mensaje"></th>
    </tr>
  </table>
</fieldset>
  <br />
  <br>
  <table width="80%" height="59" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><fieldset>
<legend>Mensaje</legend>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td>
</td>
            </tr>
            <tr>
              <td><?php echo $Mensaje->datos[0]->nombres . " " . $Mensaje->datos[0]->ape_pat . " " .
                      $Mensaje->datos[0]->ape_mat;
			  echo "<br>" . $Mensaje->datos[0]->asunto;
			  ?></td>
            </tr>
            <tr>
              <td><?php echo $Mensaje->datos[0]->mensaje; ?></td>
            </tr>
          </table>
      </fieldset></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>