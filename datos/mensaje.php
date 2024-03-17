<?php
/**
 * Clase dedicada al envio de los mensajes de todo el sistema
 *
 */
class mensaje extends conex {
	
	/**
	 * Constructor de la clase mensaje
	 *
	 * @return mensaje
	 */
	function mensaje(){
		
	}
	
	/**
	 * Lista a todos los usuarios del sistema, Administrativos, Psicologos y otros
	 *
	 */
	function listar_usuarios(){
		$sql = "select * from usuario where cargo != 'Evaluado' order by nombres";
		$this->select($sql);
	}
	
	/**
	 * Lusta a los evaluados solamente
	 *
	 */
	function listar_evaluados(){
		$sql = "select * from usuario where cargo = 'Evaluado' order by nombres";
		$this->select($sql);
	}
	
	/**
	 * Ingresa un nuevo mensaje a la base de datos enviado al o a las personas seleccionadas
	 *
	 * @param string $mensaje
	 * @param int $usuarios
	 * @param int $evaluados
	 * @param char $asunto
	 */
	function nuevo_mensaje($mensaje, $usuarios, $evaluados,$asunto){
		$remitente = $_SESSION['id'];
		$fecha = date("Y/m/d");
		//$hora = date("H:i:s");

		for ($i=0; $i < sizeof($usuarios); $i++){
			$destinatario = $usuarios[$i];
			$sql = "INSERT INTO
			  mensaje(
			  de,
			  para,
			  fecha,
			  mensaje,
			  estado,
			  asunto)
			VALUES(
			  $remitente,
			  $destinatario,
			  '$fecha',
			  '$mensaje',
			  'N',
			  '$asunto')";
			$this->insert($sql);
		}
		
		for ($i=0; $i < sizeof($evaluados); $i++){
			$destinatario = $evaluados[$i];
			$sql = "INSERT INTO
			  mensaje(
			  de,
			  para,
			  fecha,
			  mensaje,
			  estado)
			VALUES(
			  $remitente,
			  $destinatario,
			  '$fecha',
			  '$mensaje',
			  'N')";
			$this->insert($sql);
		}
	
	}
	
	/**
	 * Funci�n que se encarga de revisar cuantos mensajes tiene un determinado usuario
	 * devuelve el n�mero de mensajes sin leer
	 *
	 */
	function revisar_mensajes(){
		//$id = $_SESSION['id'];
		$this->creado_por();
		$id = $this->id_emp;
		$sql = "SELECT 
			  mensaje.id_mensaje,
			  mensaje.de,
			  mensaje.para,
			  mensaje.fecha,
			  mensaje.hora,
			  mensaje.mensaje,
			  mensaje.estado,
			  usuario.nombres,
			  usuario.ape_mat,
			  usuario.ape_pat,
			  mensaje.asunto
			FROM
			  mensaje
			  INNER JOIN usuario ON (mensaje.de = usuario.id_usuario)
			  where mensaje.para = $id and mensaje.estado = 'N'";
		$this->select($sql);
		$num_mensajes = $this->num_filas;
		$sql = "SELECT 
			  mensaje.id_mensaje,
			  mensaje.de,
			  mensaje.para,
			  mensaje.fecha,
			  mensaje.hora,
			  mensaje.mensaje,
			  mensaje.estado,
			  usuario.nombres,
			  usuario.ape_mat,
			  usuario.ape_pat,
			  mensaje.asunto
			FROM
			  mensaje
			  INNER JOIN usuario ON (mensaje.de = usuario.id_usuario)
			  where mensaje.para = $id and mensaje.estado != 'B'";
		//echo $sql;
		$this->select($sql);
		return $num_mensajes;
	}
	
	/**
	 * Borra o desactiva el mensaje sabiendo el id del mensaje
	 *
	 * @param int $id_mensaje
	 */
	function borrar_mensaje($id_mensaje){
		$sql = "UPDATE
			  mensaje
			SET
			  estado = 'B'
			 where id_mensaje = $id_mensaje";
		$this->actualizar($sql);
	}
	
	/**
	 * Muestra un mensaje en particular
	 *
	 * @param int $id_mensaje
	 */
	function ver_mensaje($id_mensaje){
		$sql = "SELECT 
			  mensaje.id_mensaje,
			  mensaje.de,
			  mensaje.para,
			  mensaje.fecha,
			  mensaje.hora,
			  mensaje.mensaje,
			  mensaje.estado,
			  usuario.nombres,
			  usuario.ape_mat,
			  usuario.ape_pat,
			  mensaje.asunto
			FROM
			  mensaje
			  INNER JOIN usuario ON (mensaje.de = usuario.id_usuario)
			  where mensaje.id_mensaje = $id_mensaje";
		$this->marcar_leido($id_mensaje);
		$this->select($sql);
		
	}
	
	/**
	 * Marca como leido un mensaje
	 *
	 * @param int $id_mensaje
	 */
	function marcar_leido($id_mensaje){
		$sql = "UPDATE
			  mensaje
			SET
			  estado = 'L'
			 where id_mensaje = $id_mensaje";
		$this->actualizar($sql);
	}
}
?>