<?php include("includes/acceso.php"); ?>
<form action="<?php echo "?" . $url . "&usr=" ?>" method="post" name="form1" id="form1">
  <table width="80%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <th scope="col"><h2>Editar Usuario</h2>
          <table width="80%" border="1" cellpadding="0" cellspacing="0">
            <tr>
              <th colspan="2" scope="col">Datos Personales              
              <input name="actualizado" type="hidden" id="actualizado" value="<?php echo $Usr->datos[0]->id_usuario; ?>" /></th>
            </tr>
            <tr>
              <td width="42%" scope="row">Nombre (s) : </td>
              <td width="58%"><input name="nombre" type="text" id="nombre" value="<?php echo $Usr->datos[0]->nombres; ?>" /></td>
            </tr>
            <tr>
              <td scope="row">Apellido Paterno: </td>
              <td><input name="app" type="text" id="app" value="<?php echo $Usr->datos[0]->ape_pat; ?>" /></td>
            </tr>
            <tr>
              <td scope="row">Apellido Materno: </td>
              <td><input name="apm" type="text" id="apm" value="<?php echo $Usr->datos[0]->ape_mat; ?>" /></td>
            </tr>
            <tr>
              <td scope="row">C.I.:</td>
              <td><input name="ci_u" type="text" id="ci_u" value="<?php echo $Usr->datos[0]->ci; ?>" /></td>
            </tr>
            <tr>
              <td scope="row">Genero:</td>
              <td> Masculino
                <input name="sexo" type="radio" id="radio" value="M" <?php if($Usr->datos[0]->genero == "M"){ echo "checked='checked'"; } ?> />
Femenino
<input type="radio" name="sexo" id="radio2" value="F" <?php if($Usr->datos[0]->genero == "F"){ echo "checked='checked'"; } ?>/></td>
            </tr>
            <tr>
              <td scope="row">Tel&eacute;fono:</td>
              <td><input name="telefono" type="text" id="telefono" value="<?php echo $Usr->datos[0]->telefono; ?>" /></td>
            </tr>
            <tr>
              <td scope="row">Direcci&oacute;n:</td>
              <td><input name="dir" type="text" id="dir" value="<?php echo $Usr->datos[0]->direccion; ?>" /></td>
            </tr>
          </table>
    <br />
          <table width="80%" border="1" cellpadding="0" cellspacing="0">
            <tr>
              <th colspan="2" scope="col">Datos de la Instituci&oacute;n </th>
            </tr>
            <tr>
              <td width="42%" scope="row">Cargo:</td>
              <td width="58%"><input name="cargo" type="text" id="cargo" value="<?php echo $Usr->datos[0]->cargo; ?>" /></td>
            </tr>
          </table>
  <br />
  <p>
            <input name="actualizar" type="submit" id="actualizar" value="Actualizar Datos" />
            <br />
        </p></th>
    </tr>
  </table>
</form>