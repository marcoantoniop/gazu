
<?php
/*
*	Sitio principal para cambiar los datos del usuario
*
*/
include_once("datos/empleado.php");
$Usr = new empleado();
$url = $_SERVER['QUERY_STRING'];

if(isset($_GET['ca'])){
	// Pimero la clave
	if(isset($_POST['clave']) and $_POST['clave1']==$_POST['clave2']){
		$a = md5($_POST['clave']);
		$nueva = md5($_POST['clave1']);
		if($Usr->clave($_SESSION['id'],$a,$nueva)){
			echo $Usr->mensaje;
			echo " �xito";
		}else{
			echo $Usr->mensaje;
			echo " Error";
		}
	// Luego para la pregunta secreta
	}elseif (isset($_POST['s_clave'])){
		$clave = md5($_POST['s_clave']);
		if($Usr->pregunta($_SESSION['id'],$clave,$_POST['p_s'],$_POST['res'])){
			echo $Usr->mensaje;
			echo " �xito";
		}else{
			echo $Usr->mensaje;
			echo " Error";
		}
	}
	
}

?>
<p>Cambiar</p>
<p><a href="<?php echo "?" . $url . "&ca=ps"; ?>">Pregunta Secreta</a></p>
<p><a href="<?php echo "?" . $url . "&ca=cl"; ?>">Clave </a></p>

<?php
if ($_GET['ca']){
	// Datos Personales
	if($_GET['ca']=="ps"){
		include_once("bloques/usuarios/c_p_secret.php");
	// Clave
	}elseif ($_GET['ca']=="cl"){
		include_once("bloques/usuarios/c_clave.php");
	}
}
?>