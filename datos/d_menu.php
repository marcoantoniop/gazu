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
class D_menu extends conex{
	/**
	 * Contiene todos los grupos que se tiene en los men�s
	 *
	 * @var Array
	 */
	var $lista_grupos;
	/**
	 * Contiene todos los elementos del grupo de menu seleccionado
	 *
	 * @var Array
	 */
	var $lista_elementos;
	/**
	 * Indica cuantos grupos hay
	 *
	 * @var Integer
	 */
	var $numero_grupos;
	/**
	 * Indica cuantos elemento hay en un grupo seleccionado
	 *
	 * @var Integer
	 */
	var $numero_elementos;

	/**
	 * Constructor de la clase menu
	 * Verifica si existen grupos e inicializa las variables
	 * Devuelve true si existe al menos un grupo de menus
	 * @return bool
	 */
	function D_menu(){
		$this->inicializa();
		// Primero sacamos todos los grupos
		$this->Actualizar_grupos();
		if($this->num_filas>0){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Carga de nuevo los datos de los grupos en el array lista_grupos
	 *
	 */
	function Actualizar_grupos(){
		$this->select("SELECT distinct(grupo) FROM menu where activo = 'S'");
		$this->numero_grupos = $this->num_filas;
		$this->numero_elementos = 0;
		for ($i=0; $i < $this->numero_grupos; $i++){
			$this->lista_grupos[$i] = $this->datos[$i]->grupo;
		}
	}
	
	/**
	 * Retorna un valor booleano de acuerdo a si existe o no un grupo
	 *
	 * @return boolean
	 */
	function Existe_grupo($grupo){
		$this->select("select count(*) as num_grupos from menu where grupo = '$grupo' and activo='S'");
		//echo $this->datos[0]->num_grupos;
		if ($this->datos[0]->num_grupos > 0)
			return true;
		else 
			return false;	
	}
	
	/**
	 * Actualiza en campo grupo para todos los elementos que pertenecen a uno determinado
	 *
	 * @param string $grupo_old, valor antiguo del grupo 
	 * @param string $grupo, nuevo nombre del grupo
	 */
	function Actualizar_Valor_Grupo($grupo_old, $grupo){
		$this->select("select id_menu from menu where grupo = '$grupo_old'");
		for ($i = 0; $i < $this->num_filas; $i ++)
			$this->insert("update menu set grupo = '$grupo' where id_menu = '".$this->datos[$i]->id_menu."'");
	}
	
	/**
	 * Inserta un elemento del menu, recibe los datos del elemento como parametros
	 *
	 * @param string $nombre, nombre del elemento
	 * @param string $url, url del elemento
	 * @param string $descripcion
	 * @param string $tipo, puede ser bloque, componente, url p ninguno
	 * @param string $grupo, grupo al que pertenece el elemento
	 */
	function Inserta_elemento($nombre, $url, $descripcion, $tipo, $grupo){
		$nombre = "'" . $nombre . "'";
		$url = "'" . $url . "'";
		$descripcion = "'" . $descripcion . "'";
		$tipo = "'" . $tipo . "'";
		$this->select("SELECT max(orden) as orden FROM menu WHERE grupo = '$grupo'");
		$orden = $this->datos[0]->orden + 1;
		//echo "insert into menu(nombre, url, orden, descripcion, grupo, tipo, activo) values ($nombre, $url, $orden, $descripcion, '$grupo', $tipo, 'S')";
		$this->insert("insert into menu(nombre, url, orden, descripcion, grupo, tipo, activo) values ($nombre, $url, $orden, $descripcion, '$grupo', $tipo, 'S')");

	}
	/**
	 * Borra un elemento de menu
	 *
	 * @param int $id_menu
	 */
	function Borra_elemento($id_menu){
		$this->insert("DELETE FROM menu WHERE id_menu=$id_menu");
	}

	/**
	 * Borra un grupo de elementos del menu
	 *
	 * @param string $grupo
	 */
	function Borra_grupo($grupo){
		$this->insert("DELETE FROM menu WHERE grupo='$grupo'");
	}
	
	/**
	 * Actualiza el campo activo de un elemento del menu a 'N', en consecuencia este ya no se muestra.
	 *
	 * @param int $id_menu, es le Id del elemento a marcar como borrado
	 */
	function Marcar_Borrado($id_menu){
		$this->insert("update menu set activo = 'N' where id_menu = $id_menu");
	}
	
	/**
	 * Actualiza el campo activo de todos los elemento del menu a 'N' para un determinado grupo
	 * en consecuencia ningun elemento de este grupo se mostrara.
	 * 
	 * @param string $grupo
	 */
	function Marcar_grupo_borrado($grupo){
		$this->insert("update menu set activo = 'N' where grupo = '$grupo'");
	}
	
	
	/**
	 * Actualiza un elemento del menu, se le debe pasar como parametros los nuevos datos del
	 * elemento y el identificador del elemento de menu.
	 *
	 * @param int $id_menu
	 * @param string $nombre
	 * @param string $url
	 * @param string $tipo
	 * @param string $grupo
	 * 
	 */
	function Actualizar_menu($id_menu, $nombre, $url, $descripcion, $tipo, $grupo){
		//echo "update menu set nombre = '$nombre', url = '$url', descripcion = '$descripcion', tipo = '$tipo', grupo = '$grupo'  WHERE id_menu = $id_menu";
		$this->insert("update menu set nombre = '$nombre', url = '$url', descripcion = '$descripcion', tipo = '$tipo', grupo = '$grupo'  WHERE id_menu = $id_menu");
	}
	/**
	 * Lista los elementos de un grupo usando como parametro su nombre
	 * Devuelve el n�mero de elementos de un grupo
	 *
	 * @param string $grupo
	 * @return int
	 */
	function Lista_elementos_m($grupo = ""){
		$this->select("select * from menu where activo='S' and grupo='$grupo' order by nombre asc");
		$this->numero_elementos = $this->num_filas;
		for ($i=0; $i < $this->numero_elementos; $i++){
			$this->lista_elementos[$i] = $this->datos[$i];
		}
		return $this->num_filas;
	}
	
	/**
	 * Lista los elementos paraa un menu determinado dependiendo del rol del
	 * usuario
	 * @version 2.0
	 * @param int $id_usuario
	 */
	function Lista_elementos_menu($id_usuario, $id_m_categoria){
		if(!$id_usuario){
			$id_usuario = "0";
		}
		//$sql = "select * from v_menus where id_usuario=$id_usuario and activo='S' order by nombre";
		$sql = "select `menu`.`nombre` AS `nombre`,
       `menu`.`descripcion` AS `descripcion`,
       `menu`.`url` AS `url`,
       `menu`.`id_menu` AS `id_menu`,
       `menu`.`funciones` AS `funciones`,
       `menu`.`orden` AS `orden`,
       `menu`.`grupo` AS `grupo`,
       `menu`.`activo` AS `activo`,
       `menu`.`tipo` AS `tipo`,
       `usuario`.`id_usuario` AS `id_usuario`,
       `menu_usuario`.`id_m_u` AS `id_m_u`,
       `menu_categoria`.`id_m_categoria` AS `id_m_categoria`,
       `menu_categoria`.`nombre` AS `nombre_categoria`,
       `menu_categoria`.`clase` AS `clase_categoria`,
       `menu_elemento`.`id_m_e` AS `id_m_e`
from ((((`usuario`
     join `menu_usuario` on ((`usuario`.`id_usuario` = `menu_usuario`.`id_emp`))
     )
     join `menu_categoria` on ((`menu_usuario`.`id_menu_categoria` =
      `menu_categoria`.`id_m_categoria`)))
     join `menu_elemento` on ((`menu_categoria`.`id_m_categoria` =
      `menu_elemento`.`id_m_categoria`)))
     join `menu` on ((`menu_elemento`.`id_menu` = `menu`.`id_menu`)))
	    where id_usuario=$id_usuario and menu.activo='S' and menu_categoria.id_m_categoria = $id_m_categoria
		order by nombre";
		$this->select($sql);
		// echo $sql;
		for ($i=0; $i < $this->num_filas; $i++){
			$this->lista_elementos[$i] = $this->datos[$i];
		}
		return $this->num_filas;
		
	}
	
	function buscar_solo_asignaciones($id_usuario){
		$sql = "select `menu`.`nombre` AS `nombre`,
       `menu`.`descripcion` AS `descripcion`,
       `menu`.`url` AS `url`,
       `menu`.`id_menu` AS `id_menu`,
       `menu`.`funciones` AS `funciones`,
       `menu`.`orden` AS `orden`,
       `menu`.`grupo` AS `grupo`,
       `menu`.`activo` AS `activo`,
       `menu`.`tipo` AS `tipo`,
       `usuario`.`id_usuario` AS `id_usuario`,
       `menu_usuario`.`id_m_u` AS `id_m_u`,
       `menu_categoria`.`id_m_categoria` AS `id_m_categoria`,
       `menu_categoria`.`nombre` AS `nombre_categoria`,
       `menu_categoria`.`clase` AS `clase_categoria`,
       `menu_elemento`.`id_m_e` AS `id_m_e`
from ((((`usuario`
     join `menu_usuario` on ((`usuario`.`id_usuario` = `menu_usuario`.`id_emp`))
     )
     join `menu_categoria` on ((`menu_usuario`.`id_menu_categoria` =
      `menu_categoria`.`id_m_categoria`)))
     join `menu_elemento` on ((`menu_categoria`.`id_m_categoria` =
      `menu_elemento`.`id_m_categoria`)))
     join `menu` on ((`menu_elemento`.`id_menu` = `menu`.`id_menu`)))
	    where id_usuario=$id_usuario and menu.activo='S' 
		GROUP BY
  menu_categoria.id_m_categoria
		order by nombre";
		$this->select($sql);
//		echo $sql;
		}
	
	/**
	 * Busca un elemento de un menu y lo devuelve
	 * Si no existe devuelve error
	 *
	 * @param int $id
	 * @return int
	 */
	function Busca_elemento($id){
		$this->select("select * from menu");
		for ($i = 0; $i < $this->num_filas; $i++){
			if (md5($this->datos[$i]->id_menu) == $id)
			$id = $this->datos[$i]->id_menu;
		}
		$this->select("select * from menu where id_menu = $id");
		return $this->datos;
	}

	/* Funcion de cambio de posicion. */
	function change_pos($id_menu, $opc){
        $grupo = $this->sacarValor("select grupo from menu where id_menu = $id_menu");
        $max = $this->sacarValor("select MAX(orden) from menu where grupo = '$grupo'");
        $min = $this->sacarValor("select MIN(orden) from menu where grupo = '$grupo'");
        $pos = $this->sacarValor("select orden from menu where id_menu = $id_menu");
        if ($max > $min){
           if ($opc == 'up'){
              $new_pos = $pos - 1;
              if ($new_pos < $min) $new_pos = $max;
           }
           else{
              $new_pos = $pos + 1;
              if ($new_pos > $max) $new_pos = $min;
           }
           $id_m = $this->sacarValor("select id_menu from menu where orden = $new_pos and grupo = '$grupo'");
           $this->sql("update menu set orden='$new_pos' where id_menu=$id_menu limit 1");
           $this->sql("update menu set orden='$pos' where id_menu=$id_m limit 1");
        }
    }
    
    /**
	 * Sube el elemento seleccionado en un nivel tomando como referencia su ID_menu
	 *
	 * @param int $id_menu
	 */
    function subir($id_menu){
        $this->change_pos($id_menu,"up");
    }
    
    /**
	 * Baja el elemento seleccionado en un nivel tomando como referencia su ID_menu
	 *
	 * @param int $id_menu
	 */
    function bajar($id_menu){
        $this->change_pos($id_menu,"down");
    }
    
    /**
     * Obtine todos los elementos que han sido desactivados 
     *
     * @return Array
     */
    function sacar_elementos_borrados(){
    	$this->select("select * from menu where activo = 'N'");
    	$lista = "";
    	for ($i = 0; $i < $this->num_filas; $i++)
    		$lista[$i] = $this->datos[$i];
    	return $lista;	
    }
    
    function habilitar_elemento($id_menu){
    	$this->insert("update menu set activo = 'S' where id_menu = $id_menu");
    }
    
    function habilitar_grupos($grupo){
    	$this->insert("update menu set activo = 'S' where grupo = $grupo");
    }

}

?>
