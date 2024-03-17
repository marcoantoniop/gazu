<form id="form1" name="form1" method="post" action="<?php echo "?" . $url . "&ca=" ?>">
<table width="265" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th colspan="2" scope="col">Cambiar Clave </th>
  </tr>
  <tr>
    <td width="169"><em>Clave Actual: </em></td>
    <td width="90"><input name="clave" type="password" id="clave" size="15"></td>
  </tr>
  <tr>
    <td>Clave Nueva: </td>
    <td><input name="clave1" type="password" id="clave1" size="15"></td>
  </tr>
  <tr>
    <td>Clave Nueva (Verificar):</td>
    <td><input name="clave2" type="password" id="clave2" size="15"></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input type="submit" name="Submit" value="Cambiar">
    </div></td>
    </tr>
</table>
</form>