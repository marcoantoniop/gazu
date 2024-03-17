<?php
include_once 'componentes/captcha/Captcha.php';
/////////////////////////////////////////////
// Acceso al sistema, Autentificaci�n
// Idioma: Espa�ol
// Especificaci�n: Am�rica Latina - Bolivia
/////////////////////////////////////////////
//echo $_SERVER['QUERY_STRING'] . "<--";
// Primero verificamos si est� correctamente accedido en el sistema
if (isset($_SESSION['usuario'])) {
	$conectado = "si";
	
	// Una vez existiendo el login verificamos si se desea salir del sistema
	if(isset($_GET['s'])==$_SESSION['usuario']){
		
		$conex = new Acceso();		
		$conex->borrar_usu($_SESSION['id']);
		
		unset ($_SESSION['usuario']);
		unset ($_SESSION['id']);
		session_destroy();
		ir("?");
		
	}
}else{
	$conectado = NULL;
}
// Luego se verifica el nombre de usuario y la clave
if (isset($_POST['usuario'])){
    if ($PHPCAP->verify($_POST['captcha'])) {
        $Acceder = new Acceso($_POST["usuario"], $_POST["clave"]);
        if ($Acceder->acceder()) {
            // Autentificaci�n del sistema
            // Se corre la rutina de acceso a todo el sistema y de encriptaci�n de datos
            $_SESSION['usuario'] = $Acceder->clave;
            $_SESSION['id'] = $Acceder->id_emp;
            $Acceder->usuarios_conectados($_SESSION['id']);
            //include_once("bloques/pagina_central/pagina_central.php");
            ir("?");
            //echo $Acceder->mensaje;
            //echo "<br>Ha accedido al sistema";
        } else {
            echo $Acceder->mensaje;
            echo "<br><h2>Error no puede acceder al sistema</h2>";
        }
    }else{
        echo "<br><h2>El CAPTCHA es incorrecto</h2>";
    }
}
// Se asignan los niveles de permisos correspondientes

// Si no existe una variable de sesi�n entonces se procede a mostrar el formulario de acceso, de lo contrario un mensaje de desconexi�n.
if (isset($_SESSION['usuario'])){
	echo "<br><a href='?" . $_SERVER['QUERY_STRING'] . "&s=" . $_SESSION['usuario'] . "'>Desconectarse</a>";
}else{
?>
    <style>

        #form1 label, #form1 input {
            display: block;
            box-sizing: border-box;
            width: 100%;
            margin-top: 10px;
            padding: 10px;
        }
    </style>
<form id="form1" name="form1" method="post" action="">
  <p>&nbsp;</p>
  <table border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699">
    <tr>
      <th height="60" colspan="2" scope="row">Acceso al sistema </th>
    </tr>
    <tr>
      <td width="130" scope="row">Usuario:</td>
      <td width="294"><input name="usuario" type="text" autofocus="autofocus" required id="usuario" size="20" maxlength="20"	/>
	  	  </td>
    </tr>
    <tr>
      <td scope="row">Clave:</td>
      <td><input name="clave" type="password" autofocus="autofocus" required="required" id="clave" size="20" maxlength="20" />
  </td>
    </tr>
      <tr>
          <td height="42" colspan="2" scope="row">
              <div align="center">
                  <label for="captcha">Verificar</label>
                  <?php
                  $PHPCAP->prime();
                  $PHPCAP->draw();
                  ?>
                  <input name="captcha" type="text" required/>
              </div>
          </td>
      </tr>
    <tr>
      <td height="42" colspan="2" scope="row">
          <div align="center">
        <input type="submit" name="Submit" value="Acceder" />
      </div></td>
    </tr>
    <tr>
      <td colspan="2" scope="row"><a href="?opc_c=acceso&amp;opc_a=r_clave">Recuperar Clave </a></td>
    </tr>
    <tr>
      <td height="50" colspan="2" scope="row"><a href="../">Ir a la p&aacute;gina principal</a></td>
    </tr>
  </table>
</form>
<?php
}
?>