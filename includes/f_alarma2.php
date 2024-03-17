<?php
//include("../componentes/ajax/TinyAjax.php");
/**
 * Primero creamos la funci�n a usar
 * @example function evento($params){}
 */
function ver_alarma(){
	include_once 'datos/mensaje.php';
	$res = new TinyAjaxBehavior();
	
	$Mensajes = new mensaje();
	if($Mensajes->revisar_mensajes() > 0){
		$res->add(TabAlert::getBehavior("Mensaje Nuevo"));
		$res->add(TabAlert::getBehavior("Al parece es urgente, mejor checalo..!!!"));
		$res->add(TabRedirect::getBehavior("?menu=f033ab37c30201f73f142449d037028d"));
		
	}else{
		//$res->add(TabAlert::getBehavior("Sin mensajes"));
	}
	return $res->getString();
}

$ajax = new TinyAjax();
$ajax->exportFunction("ver_alarma",array());
$ajax->process();
$ajax->drawJavaScript();

?>