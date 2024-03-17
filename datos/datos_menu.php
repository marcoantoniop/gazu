<?php
/**
 * @name Archivo de manejo de todo el sistema de men�s
 * nuevo parche
 * @version 2.0
 */
/**
 * Clase que maneja los datos de todo el sistema de menus
 *
 */
class Datos_menu extends conex {
	/**
	 * Constructor
	 *
	 * @return Datos_menu
	 */
	function Datos_menu(){
		$this->inicializa();
	}
	/**
	 * Muestra todos los elementos de men� sueltos.
	 *
	 */
	function Mostrar_elementos_sueltos(){
		$sql = "select * from menu order by nombre";
		$this->select($sql);
	}
	/**
	 * Guarda una nueva categor�a
	 *
	 * @param char $nombre
	 * @param char $descripcion
	 * @param int $elementos
	 */
	function Guardar_categoria($nombre, $descripcion, $elementos, $clase){
		$nombre = "'" . $nombre . "'";
		$descripcion = "'" . $descripcion . "'";
		$clase = "'" . $clase . "'";
		$sql = "insert into menu_categoria(nombre, descripcion, clase) values($nombre, $descripcion, $clase)";
		$this->insert($sql);
		$sql = "select max(id_m_categoria) as id from menu_categoria";
		$this->select($sql);
		$id = $this->datos[0]->id;
		for($i=0; $i < sizeof($elementos);$i++){
			$id_e = $elementos[$i];
			$sql = "insert into menu_elemento(id_menu,id_m_categoria) values($id_e,$id)";
			$this->insert($sql);
		}
	}
	/**
	 * Mustra las tolas las categorias
	 * Porfavor quitar la categor�a e exclusividad administrador
	 */
	function Mostrar_categorias(){
		$sql = "select * from menu_categoria";
		$this->select($sql);
	}
	/**
	 * Busca y muestra todos los datos de una categor�a
	 *
	 * @param int $id_cat
	 */
	function Buscar_categorias($id_cat){
		$sql = "SELECT 
  				menu_elemento.id_m_categoria,
  				menu_elemento.id_menu,
  				menu_categoria.descripcion,
  				menu_categoria.nombre,
  				menu_categoria.clase
					FROM
  				menu_elemento
  				INNER JOIN menu_categoria ON (menu_elemento.id_m_categoria = menu_categoria.id_m_categoria)
  				where menu_elemento.id_m_categoria = $id_cat";
		$this->select($sql);
	}
	
	/**
	 * Busca los elementos relacionando con los seleccionados
	 * utilizando el identificador de la categor�a.
	 *
	 * @param int $id_cat
	 */
	function Buscar_elementos($id_cat){
		$sql = "SELECT 
				menu_elemento.id_m_categoria,
  				menu_categoria.nombre,
  				menu_categoria.clase,
  				menu.id_menu,
  				menu.nombre,
  				menu.descripcion,
  				menu.url
					FROM
			  	menu_categoria
 		 			INNER JOIN menu_elemento ON (menu_categoria.id_m_categoria = menu_elemento.id_m_categoria)
  					INNER JOIN `menu` ON (menu_elemento.id_menu = menu.id_menu)
				WHERE
  				(menu_categoria.id_m_categoria = $id_cat)
		";
		$this->select($sql);
	}
	
	function Actualizar_elementos($id, $nombre, $descripcion, $elementos, $clase){
		$nombre = "'" . $nombre . "'";
		$descripcion = "'" . $descripcion . "'";
		$clase = "'" . $clase . "'";
		$sql = "update menu_categoria set nombre=$nombre, descripcion=$descripcion, clase=$clase where id_m_categoria=$id";
		$this->insert($sql);
		$sql = "delete from menu_elemento where id_m_categoria = $id";
		$this->actualizar($sql);
		for($i=0; $i < sizeof($elementos);$i++){
			$id_e = $elementos[$i];
			$sql = "insert into menu_elemento(id_menu,id_m_categoria) values($id_e,$id)";
			$this->insert($sql);
		}
	}
	
	/**
	 * Muestra a todos los usuarios en el sistema con todos sus datos
	 *
	 */
	function Mostrar_usuarios(){
		$sql = "select * from usuario";
		$this->select($sql);
	}
	/**
	 * Crear una asignacion a los men�s del sistema
	 *
	 * @param int $id_usuario
	 * @param int $id_m_categoria
	 */
	function Crear_asignacion($id_usuario, $id_m_categoria){
		$sql = "insert into menu_usuario(id_emp, id_menu_categoria) values($id_usuario, $id_m_categoria)";
		$this->insert($sql);
	}
	
	/**
	 * Muestra las asignaciones realizadas por el sistema
	 *
	 */
	function Mostrar_asignacion(){
		$sql = "SELECT 
		  usuario.id_usuario,
		  usuario.nombres,
  		  usuario.ape_pat,
  		  usuario.ape_mat,
  		  usuario.cargo,
  		  usuario.usuario,
  		  menu_categoria.nombre as nombre_cat,
  		  menu_categoria.id_m_categoria,
  		  menu_categoria.clase,
  		  menu_usuario.id_m_u
			FROM
  		  usuario
  		INNER JOIN menu_usuario ON (usuario.id_usuario = menu_usuario.id_emp)
  		INNER JOIN menu_categoria ON (menu_usuario.id_menu_categoria = menu_categoria.id_m_categoria)
  		order by usuario.id_usuario";
		$this->select($sql);
	}
	
	/**
	 * Quita una asignaci�n de menus
	 *
	 * @param int $id_m_u
	 */
	function Quitar_asignacion($id_m_u){
		$sql = "delete from menu_usuario where id_m_u = $id_m_u";
		$this->del($sql);
	}
	
	/**
	 * Guarda un elemento en la base de datos
	 *
	 * @param string $nombre
	 * @param string $activo
	 * @param string $url
	 * @param string $tipo
	 * @param string $funciones
	 * @param string $descripcion
	 */
	function Guardar_elementos($nombre, $activo, $url, $tipo, $funciones, $descripcion){
		$nombre = "'" . $nombre ."'" ;
		$activo = "'" . $activo ."'" ;
		$url = "'" . $url ."'" ;
		$tipo = "'" . $tipo ."'" ;
		$funciones = "'" . $funciones ."'" ;
		$descripcion = "'" . $descripcion ."'" ;
		$sql = "INSERT INTO menu(nombre, descripcion, url, funciones, activo, tipo) VALUES($nombre,$descripcion,$url,$funciones,$activo, $tipo)";
		$this->insert($sql);
		
	}
	
	/**
	 * Muestra un elemento cuando se selecciona un id
	 *
	 * @param int $id_menu
	 */
	function Mostrar_un_elemento($id_menu){
		$sql = "select * from menu where id_menu=$id_menu";
		$this->select($sql);
		
	}
	
	/**
	 * Actualiza un elemento tomando como valor su identificador
	 *
	 * @param int $id
	 * @param string $nombre
	 * @param string $activo
	 * @param string $url
	 * @param string $tipo
	 * @param string $funciones
	 * @param string $descripcion
	 */
	function Actualizar_elemento($id, $nombre, $activo, $url, $tipo, $funciones, $descripcion){
		$nombre = "'" . $nombre ."'" ;
		$activo = "'" . $activo ."'" ;
		$url = "'" . $url ."'" ;
		$tipo = "'" . $tipo ."'" ;
		$funciones = "'" . $funciones ."'" ;
		$descripcion = "'" . $descripcion ."'" ;
		$sql="UPDATE menu SET nombre = $nombre, descripcion = $descripcion, url = $url, funciones = $funciones, activo = $activo, tipo = $tipo where id_menu = $id";
		$this->actualizar($sql);
	}
}
?>