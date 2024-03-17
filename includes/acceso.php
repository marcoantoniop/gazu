<?php
/*
*	Archivo a ser incluido en todos los blosques y p�gina
*	Especificaci�n: Am�rica Latina - Bolivia
*/
if(isset($_GET['opt'])){

}else{
	if(!isset($_SESSION['usuario'])){
	echo "Acceso Restringido <a href='javascript:history.back()'>Regresar</a>";
	exit;
	exit();
	exit(0);

}	
}
?>