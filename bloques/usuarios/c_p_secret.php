<form id="form1" name="form1" method="post" action="<?php echo "?" . $url . "&ca=" ?>">
  <table width="330" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <th colspan="2" scope="col">Cambiar Pregunta Secreta </th>
    </tr>
    <tr>
      <td width="174"><em>Clave Actual: </em></td>
      <td width="150"><input name="s_clave" type="password" id="s_clave" size="25"></td>
    </tr>
    <tr>
      <td>Nueva Pregunta Secreta: </td>
      <td><input name="p_s" type="text" id="p_s" value="&iquest;?" size="25"></td>
    </tr>
    <tr>
      <td>Respuesta:</td>
      <td><input name="res" type="text" id="res" size="25"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="Submit" value="Cambiar">
      </div></td>
    </tr>
  </table>
</form>
