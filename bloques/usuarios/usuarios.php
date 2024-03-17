<?php // include("includes/acceso.php"); ?>
<?php
include_once("datos/usuario.php");
include_once("datos/empleado.php");

/*
*	Panel de administraci�n de usuarios
*	Variables: usr = nuevo, editar
*/

/**
 * Funci�n que verifica si existe datos en una variable de dia
 * si no devuelve N
 *
 * @param string $_POST['dia']
 * @return string
 */
function dia_falso($dia){
	if (!$dia){
		return "N";
	}else {
		return $dia;
	}
}


$url = $_SERVER['QUERY_STRING'];

/*
	Bloque nuevo que actualiza a los usuarios
*/
if($_POST['actualizar']){
	$Usr = new Empleado();
	$Usr->modifica_empleado($_POST['actualizado'],$_POST['nombre'],$_POST['app'],$_POST['apm'],$_POST['ci_u'],$_POST['dir'],$_POST['telefono'],$_POST['cargo'],$_POST['sexo']);
}

//echo $_GET['usr'];
// Verificamos si hay post de usuarios para modificar o desactivar
if (isset($_GET['usr'])){
	// Instanciar
	include_once("datos/empleado.php");
	$Usr = new empleado();
	
	// Procedo a realizar cambios
	if($_GET['usr']=="ed"){
		// Editar se va abajo al final
		//$Usr->listar_empleado_modif($_GET['id']);
		//include_once("bloques/usuarios/edita_usr.php");
	}elseif ($_GET['usr']=="mo"){
		// Desactivar
		$Usr->desactivar_empleado($_GET['id']);
		echo $Usr->mensaje;
	}elseif ($_GET['usr']=="ac"){
		// Desactivar
		$Usr->activar_empleado($_GET['id']);
		echo $Usr->mensaje;
	}
}


// Verificamos si hay post de usuarios para agregar nuevos usuarios
if (isset($_POST['ci'])){
	include_once("datos/empleado.php");
	//echo "Datos enviados";
	$clave = md5($_POST['clave']);
	$Usuario = new empleado();
	$fecha_n = $_POST['anio'] . "/" . $_POST['mes'] . "/" . $_POST['dia'];
	$Usuario->insert_empleado($_POST['nombre'],$_POST['app'],$_POST['apm'],$_POST['dir'],$_POST['telefono'],$_POST['ci'],$_POST['cargo'],$_POST['activo'],$clave,$_POST['p_secreta'],$_POST['r_ps'],$_POST['usuario'],$_POST['genero'], $fecha_n);
}elseif (isset($_POST['actualizado'])){
	include_once("datos/empleado.php");
	//echo "Datos enviados";
	//$Usuario = new empleado();
	//$Usuario->modifica_empleado($_POST['actualizado'],$_POST['nombre'],$_POST['app'],$_POST['apm'],$_POST['dir'],$_POST['telefono'],$_POST['cargo'],$_POST['tipo_u']);
}
?>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th colspan="2" scope="col">Adiministraci&oacute;n de Usuarios </th>
  </tr>
  <tr>
    <td scope="row"><div align="center"><a href="<?php echo "?" . $_SERVER['QUERY_STRING'] . "&"; ?>usr=nuevo">Nuevo</a></div></td>
    <td><div align="center"><a href="<?php echo "?" . $_SERVER['QUERY_STRING'] . "&"; ?>usr=editar"as">Editar</a></div></td>
  </tr>
</table>
<?php
if ($_GET['usr']=="nuevo"){
	include_once("bloques/usuarios/nue_usuario.php");
}elseif ($_GET['usr']=="editar"){
	include_once("datos/empleado.php");
	$Usr = new empleado();
	$Usr->listar_empleados();
	include_once("bloques/usuarios/edit_usuario.php");
}elseif ($_GET['usr']=="ed"){
	$Usr->listar_empleado_modif($_GET['id']);
	include_once("bloques/usuarios/edita_usr.php");
}
?>