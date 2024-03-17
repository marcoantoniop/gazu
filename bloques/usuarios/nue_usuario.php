<?php // include("includes/acceso.php");
include_once 'includes/fechas.php';
?>
<form name="form1" method="post" action="<?php echo "?" . $url . "&usr=" ?>">
  <table width="80%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <th scope="col"><h2>Adicionar Usuario</h2>
        <table width="90%" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <th colspan="2" scope="col">Datos Personales            </th>
          </tr>
          <tr>
            <td width="42%" scope="row">C.I.:</td>
            <td width="58%"><input name="ci" type="text" id="ci"></td>
          </tr>
          <tr>
            <td scope="row">Nombre (s) : </td>
            <td><input name="nombre" type="text" id="nombre"></td>
          </tr>
          <tr>
            <td scope="row">Apellido Paterno: </td>
            <td><input name="app" type="text" id="app"></td>
          </tr>
          <tr>
            <td scope="row">Apellido Materno: </td>
            <td><input name="apm" type="text" id="apm"></td>
          </tr>
          <tr>
            <td scope="row">Fecha Nacimiento:</td>
            <td>Dia:
            <?php echo listbox_date("dia"); ?>
            Mes: <?php echo listbox_month("mes"); ?>
            A&ntilde;o: <?php echo listbox_year("anio",1900, 2000); ?>
            </td>
          </tr>
          <tr>
            <td scope="row">G&eacute;nero:</td>
            <td>Masculino
              <input type="radio" name="genero" id="radio" value="M" />
            Femenino
            <input type="radio" name="genero" id="radio2" value="F" />            </td>
          </tr>
          <tr>
            <td scope="row">Tel&eacute;fono:</td>
            <td><input name="telefono" type="text" id="telefono"></td>
          </tr>
          <tr>
            <td scope="row">Direcci&oacute;n:</td>
            <td><input name="dir" type="text" id="dir"></td>
          </tr>
        </table>        
        <br>
        <table width="80%" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <th colspan="2" scope="col">Datos de la Empresa </th>
          </tr>
          <tr>
            <td width="42%" scope="row">Cargo:</td>
            <td width="58%"><input name="cargo" type="text" id="cargo"></td>
          </tr>
          <tr>
            <td scope="row">Activo: </td>
            <td><p>
              <label>
                <input name="activo" type="radio" value="s" checked>
                Si</label>
              <label>
                <input type="radio" name="activo" value="n">
                No</label>
              <br>
            </p></td>
          </tr>
        </table>
        <br>
        <table width="80%" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <th colspan="2" scope="col">Datos de Usuario </th>
          </tr>
          <tr>
            <td width="42%" scope="row">Nombre de Usuario:</td>
            <td width="58%"><input name="usuario" type="text" id="usuario"></td>
          </tr>
          <tr>
            <td scope="row">Clave: </td>
            <td><input name="clave" type="text" id="clave"></td>
          </tr>
          <tr>
            <td scope="row">Pregunta Secreta : </td>
            <td><input name="p_secreta" type="text" id="p_secreta"></td>
          </tr>
          <tr>
            <td scope="row">Respuesta a Pregunta Secreta: </td>
            <td><input name="r_ps" type="text" id="r_ps"></td>
          </tr>
        </table>
        <p>
          <input name="guardar" type="submit" id="guardar" value="Guardar Datos">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="submit" name="Submit2" value="Limpiar">
          <br>
        </p>      </th>
    </tr>
  </table>
</form>
