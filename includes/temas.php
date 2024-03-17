<?php
/////////////////////////////////////////////////////////////////////////////////////
// Archivo con funciones que permite que �stas se llamen desde el archivo de temas
// Estas crean todos los objetos necesarios para mostrar en los temas
// Idioma: Espa�ol
// Especificaci�n: Am�rica Latina - Bolivia
/////////////////////////////////////////////////////////////////////////////////////

/**
 * Despliega el menu espec�fico
 * Si no se ingresan atributos entonces devuelve el men� principal
 *
 * @param integer $id
 * @param string $nombre
 * @return array
 */
function Mostrar_menu ($id = 0, $nombre = 'Defecto'){
	$Menu = new Menu('Menu Principal');

	
	// En creaci�n
		if(isset($_SESSION['usuario'])){
			return $Menu->Llenar_menu($_SESSION['id']);
	    }else {
		    return "<h6>Por favor acceda al sistema<h6>";
		    exit();
		}
		//return $Menu->Llenar_menu($nombre);
}

function Mostrar_ClaseMenu($id = 0, $nombre = 'Defecto'){
    $ClaseMenu = new ClassMenu();
    if(isset($_SESSION['usuario'])){
        //return $ClaseMenu->Llenar_menu($_SESSION['id']);
        //return $ClaseMenu->menu_Completo($_SESSION['id']);
        $resultado = $ClaseMenu->Llenar_menu($_SESSION['id']);
        return $resultado;
    }else {
        return false;
        //return "<h6>Por favor acceda al sistema<h6>";
        //exit();

    }
}
/**
 * Muestra el cuerpo de la página Web
 * Analiza e instancia todas las conexiones a datos
 * y comprueba si existen variasbles por GET
 *
 */
function Mostrar_cuerpo(){
	
	
	if(isset($_GET['menu'])){
		$D_menu = new D_menu();
		$elemento = $D_menu->Busca_elemento($_GET['menu']);		
		echo "<h1>" . $D_menu->datos[0]->nombre . "</h1><br>";
		include_once($elemento[0]->url);
		
	}
	// Llamamos inicialmente al archivo y a la carpeta $opt
	// Si no existe entonces llamamos a la carpeta archivo y correspondientes a $opc_c y $opc_a
	if(isset($_GET['opt'])){
		include("bloques/" . $_GET['opt'] . "/" . $_GET['opt'] . ".php");
	} elseif(isset($_GET['opc_a'])) {
		include("bloques/" . $_GET['opc_c'] . "/" . $_GET['opc_a'] . ".php");
	
	}elseif(!isset($_SESSION['usuario'])){
		include_once("bloques/acceso/acceso.php");
	}
	
	if ($_SERVER['QUERY_STRING'] == "" and isset($_SESSION['usuario'])){
		include_once("bloques/pagina_central/pagina_central.php");
	}
	
	// Agregamos la excepci�n para la p�gina central con los datos del foro
	if (@$_GET['f'] and isset($_SESSION['usuario'])){
		include_once("bloques/pagina_central/pagina_central.php");
	}
	
}

/**
 * Funcion que se encarga de mostrar la fecha actual del sistema
 * y adicionalmente define cont�nuamente dos constantes
 * que son tomadas por el sistema para hacer referencia del tiempo.
 *
 */
function Mostrar_bloque_fecha(){
	/**
 	* Mes actual del sistema
 	*
 	*/
	define("mes",date('m'));
	/**
	 * A�o actual del sistema
	 */
	define("anio",date('Y'));
		switch (mes) {
				case 1:
					$mes_actual = "Enero";
					break;
				case 2:
					$mes_actual="Febrero";
					break;
				case 3:
					$mes_actual="Marzo";
					break;
				case 4:
					$mes_actual="Abril";
					break;
				case 5:
					$mes_actual="Mayo";
					break;
				case 6:
					$mes_actual="Junio";
					break;
				case 7:
					$mes_actual="Julio";
					break;
				case 8:
					$mes_actual="Agosto";
					break;
				case 9:
					$mes_actual="Septiembre";
					break;
				case 10:
					$mes_actual="Octubre";
					break;
				case 11:
					$mes_actual="Noviembre";
					break;
				case 12:
					$mes_actual="Diciembre";
					break;
			}	
	$fecha = "F: " . date('j') . " de " . $mes_actual . " de " . anio;
	return $fecha;
}

function Mostrar_usuario(){
	include_once 'datos/usuario.php';
	$Usuario = new Usuario();
	$Usuario->creado_por();
	if($Usuario->id_emp){
		$Usuario->buscar_usuario($Usuario->id_emp);
		$cadena = $Usuario->datos[0]->nombres . " " . $Usuario->datos[0]->ape_pat;
	}
	return $cadena;
	}

?>