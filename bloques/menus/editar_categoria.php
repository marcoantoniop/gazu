<?php include("includes/acceso.php"); ?>
<?php
// Acceso a Datos

// Calculos y procesos

// Eventos Ajenos

// Eventos Propios
$Categoria = new Datos_menu();
$Categoria->Buscar_categorias($_POST['id_m_categoria']);
?>

<form name="form1" method="post" action="">
  <table width="100%" border="1">
    <tr>
      <th colspan="3">Editar categor&iacute;a de acceso al sistema </th>
    </tr>
    <tr>
      <td valign="top">ID: 
        <input name="id" type="text" id="id" value="<?php echo $Categoria->datos[0]->id_m_categoria; ?>" size="4"
               maxlength="4" readonly="true" />
        <br />
        Nombre:
        <label>
          <input name="nombre" type="text" id="nombre" value="<?php echo $Categoria->datos[0]->nombre; ?>" size="25" maxlength="25">
        </label>
          <br>
          Seleccione un Ícono para su Categoría:
          <div name="clase" role="iconpicker" data-icon="<?php echo $Categoria->datos[0]->clase; ?>"></div>
          <br>
        Descripci&oacute;n:
        <label>
        <textarea name="descripcion" cols="30" id="descripcion"><?php echo $Categoria->datos[0]->descripcion; ?></textarea>
        </label>
        <p>
          <label>
          <input name="guardar_editar_cat" type="submit" id="guardar_editar_cat" value="Guardar Datos" />
          </label>
          <input type="submit" name="button" id="button" value="Cancelar" />
      </p></td>
      <td colspan="2">
      <?php
      $Categoria->Buscar_elementos($_POST['id_m_categoria']);
      for($i=0; $i<$Elementos_sueltos->num_filas; $i++){
      	$chequeado = "";
      	for($j=0;$j < $Categoria->num_filas; $j++)
      	{
      		if($Categoria->datos[$j]->id_menu == $Elementos_sueltos->datos[$i]->id_menu){
      			$chequeado = " checked='checked' ";
      		}     		
      	}
 	
      		echo "<input name='id_elemento_suelto[]' type='checkbox' value='" . $Elementos_sueltos->datos[$i]->id_menu . "'" . $chequeado . "/>";
      		echo $Elementos_sueltos->datos[$i]->nombre;
      		echo "<br>";
      }
      
      ?>
      </td>
    </tr>
  </table>
</form>
