<?php include("includes/acceso.php"); ?>
<?php
// Acceso a Datos

// Calculos y procesos

// Ejentos Ajenos 

// Eventos Propios
$Elemento = new Datos_menu();
$Elemento->Mostrar_un_elemento($_POST['id_elemento_suelto']);
?>
<form name="form1" method="post" action="">
  <fieldset>
  <legend>Editar Elemento</legend>
  <table width="100%" border="1">
    <tr>
      <td>Nombre:
      <input name="nombre" type="text" id="nombre" value="<?php echo $Elemento->datos[0]->nombre; ?>"></td>
      <td>Activo:      
        <label>
          <input name="activo" type="radio" value="S" <?php if($Elemento->datos[0]->activo == 'S'){ echo "checked"; }  ?>>
          Si</label>
        <label>
          <input type="radio" name="activo" value="N" <?php if($Elemento->datos[0]->activo == 'N'){ echo "checked"; }  ?>>
          No</label></td>
    </tr>
    <tr>
      <td>URL:
      <input name="url" type="text" id="url" value="<?php echo $Elemento->datos[0]->url; ?>" size="40"></td>
      <td>Tipo:      
        <select name="tipo" id="tipo">
          <option value="bloque" <?php if($Elemento->datos[0]->tipo == 'bloque'){ echo "selected"; }  ?>>Bloque</option>
          <option value="componente" <?php if($Elemento->datos[0]->tipo == 'componente'){ echo "selected"; }  ?>>Componente</option>
          <option value="url" <?php if($Elemento->datos[0]->tipo == 'bloque'){ echo "url"; }  ?>>URL</option>
        </select>      </td>
    </tr>
    <tr>
      <td>Funciones:
      <input name="funciones" type="text" id="funciones" value="<?php echo $Elemento->datos[0]->funciones; ?>"></td>
      <td><fieldset>
        <legend>Descripci&oacute;n</legend>
        <textarea name="descripcion" cols="60" rows="3" id="descripcion"><?php echo $Elemento->datos[0]->descripcion; ?></textarea>
        </fieldset>      �</td>
    </tr>
    <tr>
      <th colspan="2"><input name="id" type="hidden" id="id" value="<?php echo $_POST['id_elemento_suelto']; ?>" />
      <input name="actualizar_elemento" type="submit" id="actualizar_elemento" value="Guardar Elemento"> <input type="submit" name="button" id="button" value="Cancelar" /></th>
    </tr>
  </table>
  </fieldset>
</form>
