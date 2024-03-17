<?php

class conex{
	/**
	 * Almacena un SQL
	 *
	 * @var string
	 */
	var $Sql;
	
	/**
	 * Valor que determina si habr� o no paginaci�n
	 * si es que est� activo, el m�todo mostrar_paginaci�n funcionar�
	 *
	 * @var Boolean
	 */
	var $Con_Paginacion = false;
	
	/**
	 * Mensaje de error en de la base de datos
	 *
	 * @var string
	 */
	var $M_e_conex = " Error en la base de datos..!! ";
	/**
	 * Nombre del hots
	 *
	 * @var String
	 */
	var $host = CONFIG_HOST;
	/**
	 * Nombre de la base de datos
	 *
	 * @var String
	 */
	var $db;
	/**
	 * Conexion a la base de datos
	 *
	 * @var Mysql_Select_db
	 */
	var $nombre_base = CONFIG_BASE_DATOS;
	/**
	 * Clave de la base de datos
	 *
	 * @var String
	 */
	var $clave_base = CONFIG_CLAVE_BASE;
	/**
	 * Nombre de usuario de la Base de datos
	 *
	 * @var String
	 */
	var $nombre_usuario = CONFIG_USUARIO;
	/**
	 * Prefijo para poder crar nuevas tablas
	 *
	 * @var String
	 */
	var $base_prefijo = "eva_";
	/**
	 * Conexi�n a la base de datos
	 *
	 * @var Objeto
	 */
	var $conexion;
	/**
	 * N�mero de filas resultantes de la consulta
	 *
	 * @var Integer
	 */
	var $num_filas;
	/**
	 * N�mero de columnas resultante de la consulta
	 *
	 * @var String
	 */
	var $num_columnas;
	/**
	 * Todos los datos devueltos de la consulta agrupados en objetos
	 * Ejemplo:
	 * $this->datos[0]->tema; $this->datos[$i]->tema;
	 * Si la columna se llamaria tema.
	 * Debe saberse exactamente los nombres de las tablas con las que se est� trabajando.
	 *
	 * @var Objeto
	 */
	var $datos;
	/**
	 * Matriz de datos que contiene todos los datos
	 *
	 * @var Array de dos dimensiones
	 */
	var $array_datos;
	/**
	 * variable que muestra el id
	 *
	 * @var string
	 */
	var $id_emp;
	/**
	 * variable fecha
	 *
	 * @var date
	 */
		var $fecha;
	/**
	 * variable hora
	 *
	 * @var time
	 */
	var $hora;
	var $from;
	var $max_results;
	/**
	 * Identifica al m�ximo n�mero de filas a mostrarse en el paginador
	 *
	 * @var int
	 */
	var $paginador_max_filas = 20;
	/**
	 * Variable que indica el n�mero de p�gina que nos encontramos
	 *
	 * @var int
	 */
	var $paginador_pagina_actual = 0;
	/**
	 * Variable que indiaca el n�mero de p�ginas que tenemos
	 *
	 * @var int
	 */
	var $paginador_pagina_numero = 0;
	/**
	 * Indica el principio de la fila donde comenzamos a mostrar los datos
	 *
	 * @var int
	 */
	var $paginador_fila_inicio;
	/**
	 * Infica el n�mero total de p�gina que se tiene
	 *
	 * @var int
	 */
	var $paginador_total_filas;
	/**
	 * Muestra la nueva sentencia SQL preformateada para el paginado
	 *
	 * @var string
	 */
	var $sql_cadena;
	/**
	 * Indica el n�mero total de p�ginas que se van ha mostrar con el paginador
	 *
	 * @var int
	 */
	var $paginador_total_paginas = 0;
	
	/////////////////////////////////////
	// Constructor
	/////////////////////////////////////
	/**
	 * Constructor de Conex, inicializa la coneci�n a la base de datos
	 *
	 * @param String $Cfg_host
	 * @param String $Cfg_nombre_base
	 * @param String $Cfg_clave_base
	 * @param String $Cfg_nombre_usuario
	 * @param String $Cfg_base_prefijo
	 * @return Sin retorno
	 */
	/*
	function conex($Cfg_host, $Cfg_nombre_base, $Cfg_clave_base, $Cfg_nombre_usuario, $Cfg_base_prefijo){

		$this->host = $Cfg_host;
		$this->nombre_base = $Cfg_nombre_base;
		$this->clave_base = $Cfg_clave_base;
		$this->nombre_usuario = $Cfg_nombre_usuario;
		$this->base_prefijo = $Cfg_base_prefijo;
		$this->inicializa();
	}
	*/
    function conex(){

        $this->host = CONFIG_HOST;
        $this->nombre_base = CONFIG_BASE_DATOS;
        $this->clave_base = CONFIG_CLAVE_BASE;
        $this->nombre_usuario = CONFIG_USUARIO;
        $this->base_prefijo = "base_";
        $this->inicializa();
    }


	/**
	 * Inicializa la conexi�n a la base de datos
	 * En adelante se usa esta conexi�n solo si el objeto se ha heredado de la clase datos
	 * La variable $this->db contiene la conexion
	 *
	 */
	 public function inicializa(){
		    $this->conexion = mysqli_connect($this->host,$this->nombre_usuario,$this->clave_base,$this->nombre_base);
            $this->conexion->set_charset("utf8");
			//$this->conexion = mysql_connect($this->host, $this->nombre_usuario, $this->clave_base);
			$this->datos = null;
			$this->num_filas = null;
			$this->num_columnas = null;
			$this->array_datos = null;
			if (!$this->conexion) {
				die($this->M_e_conex . $this->conexion->error);
			}
			//$this->bd = mysql_select_db($this->nombre_base,$this->conexion);
		}
		//////////////////////////////////////////
		// Ejecuta un select a la base de datos
		// y retorta una matrix de datos a array_dat
	
	/**
	 * Ejecuta una consulta sql Select
	 * Alamacena los datos como num_filas, num_columas y la variable objeto datos
	 *
	 * @param string $sql
	 */
	function select($sql){
		$this->inicializa();
		//echo $sql . "<hr>";
		//$this->historial($sql);
		//$consulta = mysql_query($sql, $this->conexion);
		$consulta = mysqli_query($this->conexion, $sql);

		if (!$consulta) {
			if(Error_sql){
				ir(CONFIG_DIR_APP,50000);
				die(Error_sql_msg . "<br>" . $consulta->error . "<hr> --> " . $sql);
			}else {
				ir(CONFIG_DIR_APP,5000);
				die(Error_sql_msg);
			}
		}
		$this->num_filas = mysqli_num_rows($consulta);
		$this->num_columnas = mysqli_num_fields($consulta);
		$result = $consulta;
		$i=0;
		while ($row = mysqli_fetch_object($consulta)) {
			$this->datos[$i] = $row;
			$i++;
		}
		
	}

	/**
	 * Ejecuta una consulta sql Insert
	 *
	 * @param string $sql
	 */
	function insert($sql){
		$this->inicializa();
		//echo $sql . "<hr>";

        $consulta = mysqli_query($this->conexion, $sql);
		if (!$consulta) {
			if(Error_sql){
				ir(D_sitio_url,50000);
                die(Error_sql_msg . "<br>" . $consulta->error . "<hr> --> " . $sql);
			}else {
				ir(D_sitio_url,5000);
				die(Error_sql_msg);
			}
		}else{
		$this->historial($sql);
		}

	}
	/**
	 * Ejecuta una consulta sql Delete
	 *
	 * @param string $sql
	 */
		function del($sql){
			$this->inicializa();
			//echo $sql . "<hr>";
            $consulta = mysqli_query($this->conexion, $sql);
			if (!$consulta) {
				if(Error_sql){
					ir(D_sitio_url,50000);
                    die(Error_sql_msg . "<br>" . $consulta->error . "<hr> --> " . $sql);
				}else {
					ir(D_sitio_url,5000);
					die(Error_sql_msg);
				}
			}else{
			$this->historial($sql);
			}

		}
	/**
	 * 
	 * Ejecuta una consulta sql update
	 *
	 * @param string $sql
	 */
	function actualizar($sql){
		$this->inicializa();
		//echo $sql . "<hr>";

		$consulta = mysqli_query($this->conexion, $sql);
		if(!$consulta){
			if(Error_sql){
				ir(D_sitio_url,50000);
				die(Error_sql_msg . "<br>" . $consulta->error . "<hr> --> " . $sql);
			}else {
				ir(D_sitio_url,5000);
				die(Error_sql_msg);
			}
		}else{
		$this->historial($sql);
		}

	}
	/**
	 * Funcion Historial que se encarga de almacenas el id del empleado,fecha,y la consulta realizada
	 *
	 * @param string $cadena
	 */
	function historial($cadena){
		$this->inicializa();
		if($_SESSION['id']){
			$id_emp= $_SESSION['id'];
		}else {
			$id_emp = 0;
		}
		
		$fecha = "'" . date("Y-m-d") . "'";
		$cadena = "'" . addslashes($cadena) . "'";
		$sql = "insert into historial (id_emp,fecha,cadena) values ($id_emp,$fecha, $cadena)";
		
		$query = mysqli_query($this->conexion, $sql);
		if(!$query){
			die($this->M_e_conex . $query->error . " --> " . $sql);
		}
		

	}

	var $resSql = "";

	
	function sql($sql){

        if (strlen($sql) != 0)
        {
            $this->resSql = mysqli_query($this->conexion, $sql) or die('Error al hacer la consulta. '.mysqli_error());
        }

    }
    
    /**
     * Saca una fila de la consulta
     *
     */
    function sacarFila(){
        return @mysqli_fetch_array($this->resSql);
    }
    
    /**
     * Devuelve la primera fila y el primer valor de la consulta
     *
     * @param string $sql
     * @return object
     */
    function sacarValor($sql){
        $this->sql($sql);
        $valor = $this->sacarFila();
        return $valor[0];
    }
    
	/**
	 * funcion encargada de mostrar la hora,fecha y el id del empleado
	 * Variables
	 * 	$fecha
	 *  $hora
	 *  $id_emp
	 *
	 */
    function creado_por(){
    $id_emp=$_SESSION['id'];	
    $fecha= date('Y/m/d');
    $hora= date('H:i:s');
	$this->id_emp= $id_emp;	
	$this->fecha = $fecha;
	$this->hora = $hora;
	
    }
	/**
	 * funcion encargada de poner la primera letra en mayuscula
	 *
	 * @param string $valor
	 * @return $cadena
	 */
    function cambiar_letra($valor){
		$cadena = $valor;
		$cadena = ucwords($cadena);

		$cadena = $valor;
		$cadena = ucwords($cadena);
		$cadena = ucwords(strtolower($cadena));
		return $cadena;
		
	}
	/**
	 * Funcion encargada de convertir una cadena en mayusculas
	 *
	 * @param string $valor
	 * @return $cadena
	 */
	function mayusculas($valor){
		$cadena =$valor;
		$cadena = strtoupper ($cadena);
		return $cadena;
	}
	/**
	 * funcion encargada de devolver datos de acuerdo al tipo de usuario que se pida
	 *
	 * @param string $cadena
	 */
	function devolver_tipos_usuarios($cadena){
		$sql="select * from usuario where tipo_usuario = '$cadena' and activo='S'";
		$this->select($sql);
	
			
	}

	
	function obtener_ip(){
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
			return $_SERVER['HTTP_CLIENT_IP'];
	    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
	    return $_SERVER['REMOTE_ADDR'];
	}

    function analizar_datos_cadena($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

        switch ($theType) {
            case "date":
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }

}
?>