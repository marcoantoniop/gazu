<?php
/////////////////////////////////////////////
// Clases de tabla Empleado
// Idioma: Espa�ol
// Especificaci�n: Am�rica Latina - Bolivia
/////////////////////////////////////////////
/**
 * 
 * Clase empleado que se encarga de insertar empleados y listar los mismos
 *
 */
class Empleado extends conex{
/**
 * Para mostrar mensajes
 *
 * @var string $mensaje
 */
	var  $mensaje;
/**
 * Funcion para inicializar la clase empleado
 *
 * @return empleado
 */
	function Empleado(){
		$this->inicializa();
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
 */
	function insert_empleado($nombres,$ape_pat,$ape_mat,$direccion,$telefono,$ci,$cargo,$activo,$clave,$preg_sec,$resp_sec,$usuario,$genero, $fecha_n){
		
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
				$sql1= "insert into usuario(nombres,ape_pat,ape_mat,direccion,telefono,ci,cargo,activo,clave,preg_sec,resp_sec,usuario,genero, fecha_nac) values ('$nombres','$ape_pat','$ape_mat','$direccion','$telefono',$ci,'$cargo','$activo','$clave','$preg_sec','$resp_sec','$usuario','$genero', '$fecha_n')";
				$this->insert($sql1);
				
			}
			$this->mensaje= "el nombre de usuario ya existe introducir otro nombre";

		}
		$this->mensaje= "el ci ya existe introducir otro";
	}
/**
 * Funcion encargada de listar empleados ci,ape_pat,ape_mat,cargo,id_usr
 *
 */
	function listar_empleados(){
		$sql ="select * from usuario";
		$this->select($sql);
	}

/**
 * Funcion que se encarga de mostrar los datos de un empleado seleccionado
 *
 * @param int $id_emp
 */

	function listar_empleado_modif($id_emp){
		$sql="select * from usuario where id_usuario=$id_emp";
		$this->select($sql);

	}

/**
 * Funcion que se encarga de modificar al empleado
 *
 * @param int $id_emp
 * @param string $nombres
 * @param string $ape_mat
 * @param string $ape_pat
 * @param string $ci
 * @param string $direccion
 * @param string $telefono
 * @param string $cargo
 * @param string $sexo
 * @param string $id_usr
 */
	function modifica_empleado($id_emp,$nombres,$ape_pat,$ape_mat, $ci,$direccion,$telefono,$cargo, $sexo){
		
		$nombres = $this->cambiar_letra($nombres);
		$ape_pat = $this->cambiar_letra($ape_pat);
		$ape_mat = $this->cambiar_letra($ape_mat);
		$direccion = $this->cambiar_letra($direccion);
		$cargo = $this->cambiar_letra($cargo);
		$sql ="update usuario set nombres='$nombres',ape_pat='$ape_pat',ape_mat='$ape_mat',direccion='$direccion',telefono='$telefono',cargo='$cargo', ci='$ci',genero='$sexo' where id_usuario='$id_emp'";
		//echo $sql;
		$this->actualizar($sql);


	}

 /**
 * Funcion que se encarga de desactivar al empleado, coloca en el campo activo el atributo n
 *
 * @param int $id_emp
 */
	function desactivar_empleado($id_emp){
		$sql1="update usuario set activo='n' where id_usuario=$id_emp";
		$this->actualizar($sql1);

	}
/**
 * Funcion que se encarga de activar al empleado, coloca en el campo activo el atributo s
 *
 * @param int $id_emp
 */
	function activar_empleado($id_emp){
		$sql1="update usuario set activo='s' where id_usuario=$id_emp";
		$this->actualizar($sql1);

	}
 /**
 * Funcion que se encarga de buscar la pregunta secreta de un usuario
 *
 * @param string $ci
 * @param string $id_usr
 */
 function buscar_preg($ci,$id_usr){
 	$sql3="select * from usuario where ci='$ci' and usuario='$id_usr'";
 	$this->select($sql3);
 	
 	if ($this->num_filas==1) {
 		return true;
 	}else{
 		return false;
 	}
 }
/**
 * funcion encargada de verificar la respuesta si es correcta me devuelve true si es incorrecta me 
 * devuelve false
 * 
 * @param int $id_emp
 * @param string $resp_sec
 * @return true - false
 */
	function verificar_resp($id_emp,$resp_sec){
		$sql1="select resp_sec from usuario where id_usuario=$id_emp";
		$this->select($sql1);

		$pre= $this->datos[0]->resp_sec;
		if ($resp_sec==$pre) {
			$this->mensaje ="la respuesta es correcta";
			return  true;
		}else {
			$this->mensaje = "la respuesta es incorrecta";
			return false;
		}
	}
/**
 * Funcion encargada de cambiar la contrase�a del usuario
 *
 * @param int $id_emp
 * @param string $clave
 */
	function cambiar_clave($id_emp,$clave){
		$sql2= "update usuario set clave='$clave' where id_usuario=$id_emp";
		$this->actualizar($sql2);
		
	}
/**
 * Funcion en la que se realiza la verificacion de la contrase�a actual
 *
 * @param int $id_emp
 * @param string $clave
 */
	function clave($id_emp,$clave,$clavenu){
		$sql= "select id_usuario,clave from usuario where id_usuario=$id_emp"	;
		$this->select($sql);
		$cla=$this->datos[0]->clave;

		if ($clave==$cla) {
			$this->actualizar_clave($id_emp,$clavenu);
			$this->mensaje ="esta bien";
			return true;
			
		}else{
			$this->mensaje= "La contrase�a actual es incorrecta";
			return false;
		}

	}
/**
 * Funcion que se encarga de modificar la contrase�a una vez que se haya hecho la 
 * verificacion de la contrase�a actual
 *
 * @param int $id_emp
 * @param string $clave
 */
	function actualizar_clave($id_emp,$clavenu){
		$sql1="update usuario set clave='$clavenu' where id_usuario=$id_emp";
		$this->actualizar($sql1);
	}
	
/**
 * Funcion que se encarga de cambiar la pregunta secreta
 *
 * @param int $id_emp
 * @param string $clave
 * @param string $preg_sec
 * @param string $resp_sec
 * @return string
 */
	function pregunta($id_emp,$clave,$preg_sec,$resp_sec){
		$sql= "select * from usuario where id_usuario=$id_emp"	;
		$this->select($sql);
				
		$cla=$this->datos[0]->clave;

		if ($clave==$cla) {
			$this->cambiar_pre($id_emp,$preg_sec,$resp_sec);
			$this->mensaje ="esta bien";
			return true;
			
		}else{
			$this->mensaje= "La contrase�a es incorrecta";
			return false;
		}
	}
	
/**
 * Funcion encargada de actualizar la pregunta secreta
 *
 * @param int $id_emp
 * @param string $clave
 * @param string $preg_sec
 * @param string $resp_sec
 */
	function cambiar_pre($id_emp,$preg_sec,$resp_sec){
		$sql1="update usuario set preg_sec='$preg_sec',resp_sec='$resp_sec' where id_usuario=$id_emp";
		$this->actualizar($sql1);
	}
	
}

?>