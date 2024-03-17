<?php
/////////////////////////////////////////////
// Clases de tabla Usuario y acceso
// Idioma: Espa�ol
// Especificaci�n: Am�rica Latina - Bolivia
// Autor: Lourdes Veizaga
// Modificado y Actualizado Por: Newton, 04-10-06
// Fecha: 25 de septiembre de 2006
/////////////////////////////////////////////
/**
 * 
 * Clase Usuario
 *
 */

class Usuario extends conex {
	
	function usuario(){
		$this->inicializa();
	}
	
/**
 * Contine la lista de los usuarios actuales
 *
 * @var Array
 */
  var $lista_usuarios;
  	
/**
 * Contine la lista de los permisos de un usuario
 *
 * @var Array
 */
  var $lista_usuario_permisos;

/**
 * 
 * Funcion Insertar acceso a tabla acceso
 *
 * @param int $id_acceso
 * @param datetime $fecha
 * @param int $id_emp
 * @param string $ip
 * @param string $accion
 * @param time $hora
 */
	function insert_acceso($fecha,$i,$ip,$accion,$hora){
		$sql="insert into acceso(fecha,id_emp,ip,accion,hora)values('$fecha',$i,'$ip','$accion','$hora')";
		if(!isset($_SESSION['usuario'])){
			$this->insert($sql);
		}
	}
	
	/**
	 * Saca todos los usuarios del sistema
	 *
	 * @return object
	 */
	function sacar_usuarios(){
		$this->select("select * from usuario");
		for($i = 0; $i < $this->num_filas; $i++)
			$this->lista_usuarios[$i] = $this->datos[$i];
		return $this->lista_usuarios;
	}
	
	/**
	 * Da permisos a un usuario en especial
	 *
	 * @param int $id_usr
	 * @param int $id_menu
	 */
	function insertar_permiso($id_usr, $id_menu){
		$this->insert("insert into menu_usuario(id_usr, id_menu) values('$id_usr','$id_menu')");
	}
	
	/**
	 * Extrae los permisos de un deperminado usuairo
	 *
	 * @param int $id_usr
	 * @param boolean $soloper
	 * @return object
	 */
	function sacar_permisos($id_usr, $soloper = false){
		if ($soloper)
			$this->select("select m.id_menu, nombre nom, m.descripcion des, url, grupo from menu m, menu_usuario mu, empleado e where m.id_menu = mu.id_menu and mu.id_usr = e.id_usr and e.id_usr = '$id_usr'");
		else
			$this->select("select id_menu, nombre nom, descripcion des, url, grupo, IF(id_menu IN (select m.id_menu from menu m, menu_usuario mu, empleado e where m.id_menu = mu.id_menu and mu.id_usr = e.id_usr and e.id_usr = '$id_usr'), true, false) per from menu;");
		for($i = 0; $i < $this->num_filas; $i++)
			$this->lista_usuario_permisos[$i] = $this->datos[$i];
		return $this->lista_usuario_permisos;
	}

	/**
	 * Quita los permisos a un usuario del sistema
	 *
	 * @param int $id_usr
	 * @param int $id_menu
	 */
	function borrar_permiso($id_usr, $id_menu){
		$this->del("delete from menu_usuario where id_usr = '$id_usr' and id_menu = $id_menu");
	}
	
	/**
	 * Quita los permisos a un usuario del men� del sistema
	 *
	 * @param int $id_usr
	 */
	function truncar_permisos($id_usr){
		$this->del("delete from menu_usuario where id_usr = '$id_usr'");
	}
	
	/**
 * Funcion insertar empleado a la tabla empleado
 *
 * @param string $nombres
 * @param string $ape_pat
 * @param string $ape_mat
 * @param string $direccion
 * @param string $telefono
 * @param string $ci
 * @param string $cargo
 * @param string $activo
 * @param time $h_ent_m
 * @param time $h_sal_m
 * @param time $h_ent_t
 * @param time $h_sal_t
 * @param string $lunes
 * @param string $martes
 * @param string $miercoles
 * @param string $jueves
 * @param string $viernes
 * @param string $sabado
 * @param string $domingo
 * @param string $clave
 * @param string $preg_sec
 * @param string $resp_sec
 * @param string $descripcion
 * @param string $id_usr
 * @param string $tipo_usuario
 * @param date $fecha_n
 */
	function insert_usuario($nombres,$ape_pat,$ape_mat,$direccion,$telefono,$ci,$cargo,$activo,$clave,$preg_sec,$resp_sec,$usuario,$genero,$fecha_n){
		
		$nombres = $this->cambiar_letra($nombres);
		$ape_pat = $this->cambiar_letra($ape_pat);
		$ape_mat = $this->cambiar_letra($ape_mat);
		$direccion = $this->cambiar_letra($direccion);
		$cargo = $this->cambiar_letra($cargo);
		$id_usuario = $_SESSION['id'];
		$sql="select ci from usuario where ci=$ci";
		$this->select($sql);
		$sql2="select id_usuario from usuario where id_usuario=$id_usuario";
		$this->select($sql2);
		if ($ci != $this->datos[0]->ci) {
			$cadena= $id_usuario;
			$cadena = strtoupper ($cadena);

			$id= "'" . $this->datos[0]->id_usr . "'" ;

			if ($cadena != $id) {
				$sql1= "insert into usuario(nombres,ape_pat,ape_mat,direccion,telefono,ci,cargo,activo,clave,preg_sec,resp_sec,usuario,genero, fecha_nac) values ('$nombres','$ape_pat','$ape_mat','$direccion','$telefono',$ci,'$cargo','$activo','$clave','$preg_sec','$resp_sec','$usuario','$genero','$fecha_n')";
				$this->insert($sql1);
				
			}
			$this->mensaje= "el nombre de usuario ya existe, introduzca otro nombre";

		}
		$this->mensaje= "el ci ya existe, introduzca otro";
	}
	
	/**
	 * Devuelve el usuario logueado actual
	 */
	function devolver_usuario_actual(){
		$this->creado_por();
		$id_usuario = $this->id_emp;
		$sql = "select * from usuario where id_usuario = $id_usuario";
		$this->select($sql);
	}
	
	function sacar_usuarios_cuenta(){
		$sql = "SELECT 
		  producto.nombre as nombre_cuenta,
		  usuario.id_usuario,
		  usuario.ci,
		  usuario.nombres,
		  usuario.ape_pat,
		  usuario.ape_mat,
		  usuario.genero,
		  usuario.direccion,
		  usuario.telefono,
		  usuario.fecha_nac,
		  usuario.usuario,
		  usuario.clave,
		  usuario.cargo,
		  usuario.activo,
		  usuario.preg_sec,
		  usuario.resp_sec,
		  usuario.cuenta_privada
		FROM
		  producto
		  RIGHT OUTER JOIN usuario ON (producto.id_p = usuario.cuenta_privada)";
		$this->select($sql);
	}
	
	function buscar_usuario($id_usuario){
		$sql = "select * from usuario where id_usuario = $id_usuario";
		$this->select($sql);
	}
}
?>