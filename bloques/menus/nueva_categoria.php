<?php include("includes/acceso.php"); ?>
<?php
// Acceso a Datos

// Calculos y procesos

// Ejentos Ajenos

// Eventos Propios

?>
<form name="form1" method="post" action="">
  <table width="100%" border="1">
    <tr>
      <th colspan="3">Crear nueva categor&iacute;a de acceso al sistema </th>
    </tr>
    <tr>
      <td valign="top">Nombre:
        <label>
          <input name="nombre" type="text" id="nombre" size="25" maxlength="25">
        </label>
          <br>
          <!-- Button tag -->
          Seleccione un Ícono para su Categoría:
<!--          <button class="btn btn-secondary" role="iconpicker"></button>-->
          <div name="clase" role="iconpicker" data-icon=""></div>
          <br>
        Descripci&oacute;n:
        <label>
        <textarea name="descripcion" cols="30" id="descripcion"></textarea>
        </label>
          <br>
          <label>
          <input name="guardar_nueva_cat" type="submit" id="guardar_nueva_cat" value="Guardar Datos" />
          </label>
          <input type="submit" name="button" id="button" value="Cancelar" />
        </td>
      <td colspan="2">
      <?php
      for($i=0; $i<$Elementos_sueltos->num_filas; $i++){
      		echo "<input name='id_elemento_suelto[]' type='checkbox' value='" . $Elementos_sueltos->datos[$i]->id_menu . "' />";
      		echo $Elementos_sueltos->datos[$i]->nombre;
      		echo "<br>";
      }
      ?>
      </td>
    </tr>
  </table>
</form>
