<?php include("includes/acceso.php"); ?>
<form name="form1" method="post" action="">
  <fieldset><legend>Nuevo Elemento</legend><table width="100%" border="1">
    <tr>
      <td>Nombre:
      <input name="nombre" type="text" id="nombre"></td>
      <td>Activo:      
        <label>
          <input name="activo" type="radio" value="S" checked>
          Si</label>
        <label>
          <input type="radio" name="activo" value="N">
          No</label></td>
    </tr>
    <tr>
      <td>URL:
      <input name="url" type="text" id="url" value="bloques/" size="40"></td>
      <td>Tipo:      
        <select name="tipo" id="tipo">
          <option value="bloque" selected>Bloque</option>
          <option value="componente">Componente</option>
          <option value="url">URL</option>
        </select>      </td>
    </tr>
    <tr>
      <td>Funciones:
      <input name="funciones" type="text" id="funciones"></td>
      <td><fieldset>
        <legend>Descripci&oacute;n</legend>
        <textarea name="descripcion" cols="60" rows="3" id="descripcion"></textarea>
        </fieldset>      �</td>
    </tr>
    <tr>
      <th colspan="2"><input name="guardar_elemento" type="submit" id="guardar_elemento" value="Guardar Elemento"> <input type="submit" name="button" id="button" value="Cancelar" /></th>
    </tr>
  </table>
  </fieldset>
</form>
