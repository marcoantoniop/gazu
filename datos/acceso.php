<?php
/////////////////////////////////////////////
// Archivo de datos para editar todos los menus
// Idioma: Espa�ol
// Especificaci�n: Am�rica Latina - Bolivia
/////////////////////////////////////////////
/**
 * Clase dedicada a todo el funcionamiento de los menus de todo el sistema
 *
 */
class Acceso extends usuario {
	/**
	 * Almacena el nombre de usuario del sistema
	 *
	 * @var string
	 */
	var $usuario;
	/**
	 * Almacena el ID del empleado
	 *
	 * @var string
	 */
	var $id_emp;
	/**
	 * Almacena la clave del usuario cifrada con MD%
	 *
	 * @var string
	 */
	var $clave;
	/**
	 * Indica el nivel al que tiene acceso el usuario
	 *
	 * @var Integer
	 */
	var $nivel = 0;
	/**
	 * Fecha Actual
	 *
	 * @var date
	 */
	var $fecha;
	/**
	 * Hora Actual
	 *
	 * @var Time
	 */
	var $hora;
	/**
 * Para mostrar mensajes
 *
 * @var string $mensaje
 */
	var  $mensaje;
/**
 * Constructor del Sistema
 *
 * @param string $usuario
 * @param string $clave
 */

	function Acceso($usuario = "", $clave = ""){
		$this->usuario = $usuario;
		$this->clave = md5($clave);
	}
/**
 * Funcion que verifica si el usuario existe
 * Devuelve TRUE si existe y FALSE si existen duplicados o no existe el usuario
 *
 * @return boolean
 */
	function acceder(){
		$usuario = "'" . $this->usuario . "'";
		$clave = "'" . $this->clave . "'";
		$sql = "select * from usuario where usuario = $usuario and clave = $clave and activo = 's'";
		$this->select($sql);
		$i= $this->datos[0]->id_usuario;
		$this->id_emp = $i;
		if ($this->num_filas == 1){
				return true;
		}else{return false;}
	}
/**
 * Funcion para verificar si el usuario se encuentra dentro de los dias y horas
 * de trabajo, $i= variable en la que se almacena el id_emp(id del empleado)
 *
 * @param int $i
 */

	function verif_horas($i){
		$sql= "select h_ent_m,h_sal_m,h_ent_t,h_sal_t,lunes,martes,miercoles,jueves,viernes,sabado,domingo from usuario where id_usuario= $i";
		$this->select($sql);
		$hora= date('H:i:s');
		$fecha= date('Y/m/d');
		$this->fecha = $fecha;
		$this->hora = $hora;
		$ip= $this->get_ip();
		$accion= 'login';
		//$status = $status = explode('  ', mysql_stat($this->conexion));


		/* nos muestra el ip de la maquina
		$ip= $_SERVER['REMOTE_ADDR'];*/

		/*nos muestra el nombre del equipo
		$ip=gethostbyaddr("$REMOTE_ADDR") ;*/
		if ($hora>=$this->datos[0]->h_ent_m and $hora<=$this->datos[0]->h_sal_m) {
			$dia = $this->Ver_dia(date('D'));
			$hoy= $dia;
			$sql1= "select $hoy from usuario where id_usuario=$i";
			$this->select($sql1);
			
			$sql2="select $hoy as dia from usuario";
			$this->select($sql2);

			if ($this->datos[0]->dia==S) {
				$this->mensaje= "BIENVENIDO AL SISTEMA";
				
				$this->insert_acceso($fecha,$i,$ip,$accion,$hora);
				return true;

			}else {

				$this->mensaje= "ACCESO DENEGADO";
				return false;
			}

		}else {
			if ($hora>=$this->datos[0]->h_ent_t and $hora<=$this->datos[0]->h_sal_t) {
				$dia = $this->Ver_dia(date('D'));
				$hoy= $dia;
				$sql1= "select $hoy from usuario where id_usuario=$i";
				$this->select($sql1);
							
				$sql2="select $hoy as dia from usuario";
				$this->select($sql2);

				if ($this->datos[0]->dia==S) {
					//porsi acaso
					
					$this->mensaje= "BIENVENIDO AL SISTEMA";
					$this->insert_acceso($fecha,$i,$ip,$accion,$hora);
			
					
					return true;
				}else {

					$this->mensaje= "ACCESO DENEGADO";
					
					return false;}

			}else {
				$this->mensaje= "USTED SE ENCUENTRA FUERA DE LAS HORAS DE TRABAJO";
				return false;
			}
		}

	}

/**
 * funcion que se encarga de transformar los dias de la semana en espa�ol
 *
 * @param  $dia
 * @return $vd
 */
	function Ver_dia($dia){
	    $vd = "";
		switch ($dia){
			case "Mon":
				$vd = "Lunes";
				break;
			case "Tue":
				$vd = "Martes";
				break;
			case "Wed":
				$vd = "Miercoles";
				break;
			case "Thu":
				$vd = "Jueves";
				break;
			case "Fri":
				$vd = "Viernes";
				break;
			case "Sat":
				$vd = "Sabado";
				break;
			case "Sun":
				$vd = "Domingo";
				break;
		}

		return $vd;
	}
	
	function Ver_mes($mes){
		switch ($mes){
			case "January":
				$vd = "Enero";
				break;
			case "February":
				$vd = "Febrero";
				break;
			case "March":
				$vd = "Marzo";
				break;
			case "April":
				$vd = "Abril";
				break;
			case "May":
				$vd = "Mayo";
				break;
			case "June":
				$vd = "Junio";
				break;
			case "July":
				$vd = "Julio";
				break;
			case "August":
				$vd = "Agosto";
				break;
			case "September":
				$vd = "Septiembre";
				break;
			case "October":
				$vd = "Octubre";
				break;
			case "November":
				$vd = "Noviembre";
				break;
			case "December":
				$vd = "Diciembre";
				break;
		}

		return $vd;
		
	}

/**
 * Funcion que se encarga de entregar el ip de la maquina cliente
 *
 * @return $ip
 */
	function get_ip()
	{
		if (preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["HTTP_CLIENT_IP"]))
		{$ip = $_SERVER["HTTP_CLIENT_IP"];} 	else
		{
			if (preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["HTTP_X_FORWARDED_FOR"]))
			{  $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; }	  else{
				if (preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["REMOTE_HOST"]))
				{$ip = $_SERVER["REMOTE_HOST"]; }		  else 		{
					$ip = $_SERVER["REMOTE_ADDR"]; }
			}}
			return($ip);
	}
/**
 * Funcion que se encarga de insertar a los usuario que estan en linea a la tabla usu_conec
 *
 * @param int $i
 */
	function usuarios_conectados($i){
		$sql= "select id_usuario from usuario where id_usuario=$i";
		$this->select($sql);
		$id_emp= $i;
		$this->creado_por();
		$nombre=$this->datos[0]->id_usuario;
		$id_session=$_SESSION['usuario'];
		$id_ss=$_SESSION['id'];
		$fecha = $this->fecha;
		$hora = $this->hora;

		$sql2= "select id_emp from usu_conec where id_emp=$id_ss";
		$this->select($sql2);

		if ($this->num_filas==0){

			$sql1="insert into usu_conec(id_emp,nombre,id_session,fecha,hora)values('$id_emp','$nombre','$id_session','$fecha','$hora')";
			$this->insert($sql1);
			
		}else{
			// Por no falso
			//echo "estas en linea";
		}

	}
/**
 * funcion encargada de borrar usuarios
 *
 * @param int $i
 */
	function borrar_usu($i){
		if(!$i){
			$i=0;
		}
		$sql="select id_emp from usu_conec where id_emp=$i";
		$this->select($sql);
		
		$chau=$this->datos[0]->id_emp;
		if(!$chau){
			$chau=0;
		}
		$sql1= "delete from usu_conec where id_emp=$chau";
		$this->del($sql1);

	}



}
	

?>