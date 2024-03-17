<?php
/////////////////////////////////////////////
// Cambia la clave del sistema
// Idioma: Espa�ol
// Especificaci�n: Am�rica Latina - Bolivia
/////////////////////////////////////////////
include_once("datos/empleado.php");
$url = $_SERVER['QUERY_STRING'];
$Usr = new Empleado();

if (!strstr($url, 'p=')){
	unset($_SESSION['rc']);
}

if(isset($_SESSION['rc'])){
	if($_GET['p']==1){
		if($Usr->buscar_preg($_POST['ci'],$_POST['usuario'])){
			$_SESSION['rc']=1;
			$_SESSION['util_r']=$Usr->datos[0]->id_usuario;
		}
	}elseif ($_GET['p']==2){
		if($Usr->verificar_resp($_SESSION['util_r'],$_POST['respuesta'])){
			$_SESSION['rc']=2;
		}
	}elseif ($_GET['p']==3){
		if($_POST['clave']==$_POST['clave2']){
			$clave = md5($_POST['clave']);
			$Usr->cambiar_clave($_SESSION['util_r'],$clave);
			echo "Su clave se ha cambiado con exito";
			unset($_SESSION['util_r']);
			unset($_SESSION['rc']);
			ir("?",2000);
		}
	}
	
}else {
	$_SESSION['rc']=0;
}

?>
<?php
	if($_SESSION['rc']==0){
?>
<style type="text/css">
<!--
.Estilo2 {color: #000000}
-->

    .tabla_a{
        width: 35%;
        border: 1px;
        horiz-align: center;
        padding: 0;

    }
</style>

<form name="form1" method="post" action="<?php echo "?" . $url . "&p=1" ?>">
  <table class="tabla_a">
    <tr>
      <th colspan="2" scope="col">Recuperar Clave </th>
    </tr>
    <tr>
      <td colspan="2"><div align="center">Por favor ingrese su numero de ci y su nombre de usuario </div></td>
    </tr>
    <tr>
      <td width="57%">C.I:</td>
      <td width="43%"><input name="ci" type="text" autofocus="autofocus" required="required" id="ci" size="15" maxlength="8">
      </td>
    </tr>
    <tr>
      <td>Nombre de Usuario: </td>
      <td><input name="usuario" type="text" autofocus="autofocus" required="required" id="usuario" size="15" maxlength="30">
      </td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input name="Submit" type="submit" autofocus="autofocus" value="Buscar">
      </div></td>
    </tr>
    <tr bgcolor="#000000">
      <th colspan="2" bgcolor="#CCCCCC"><span class="Estilo2"><a href="<?php echo $Cfg_dir_url . "??"; ?>">Intentar
                  acceder nuevamente</a></span></th>
    </tr>
  </table>
</form>
<?php }
	if($_SESSION['rc']==1){
?>

<form name="form2" method="post" action="<?php echo "?" . $url . "&p=2" ?>">
  <table width="35%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <th colspan="2" scope="col">Recuperar Clave </th>
    </tr>
    <tr>
      <td colspan="2"><div align="center">Por favor ingrese la respuesta a su pregunta secreta </div></td>
    </tr>
    <tr>
      <td colspan="2"><?php echo $Usr->datos[0]->preg_sec; ?></td>
    </tr>
    <tr>
      <td width="27%">Respuesta: </td>
      <td width="73%"><input name="respuesta" type="text" autofocus="autofocus" required="required" id="respuesta" size="30">
	  	  </td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
          <input type="submit" name="Submit2" value="Verificar">
      </div></td>
    </tr>
    <tr bgcolor="#000000">
      <th colspan="2" bgcolor="#CCCCCC"><span class="Estilo2"><a href="<?php echo $Cfg_dir_url . "??"; ?>">Intentar
                  acceder nuevamente</a></span></th>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
</form>
<?php }
	if($_SESSION['rc']==2){
?>

<form name="form3" method="post" action="<?php echo "?" . $url . "&p=3" ?>">
  <table width="48%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <th colspan="2" scope="col">Recuperar Clave </th>
    </tr>
    <tr>
      <td colspan="2"><div align="center">Por favor ingrese su nueva contrase&ntilde;a </div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Nueva Clave:</td>
      <td><input name="clave" type="password" autofocus="autofocus" required="required" id="clave" size="25">
	  	  </td>
    </tr>
    <tr>
      <td width="58%">Nueva Clave (verificaci&oacute;n): </td>
      <td width="42%"><input name="clave2" type="password" required="required" id="clave2" size="25">
	  	  </td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
          <input type="submit" name="Submit22" value="Cambiar">
      </div></td>
    </tr>
    <tr bgcolor="#000000">
      <th colspan="2" bgcolor="#CCCCCC"><span class="Estilo2"><a href="<?php echo $Cfg_dir_url . "??"; ?>">Intentar
                  acceder nuevamente</a></span></th>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
</form>
<?php
	}
echo $Usr->mensaje;
?>