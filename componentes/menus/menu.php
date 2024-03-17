<?php
/////////////////////////////////////////////
// Archivo general de temas Clase Tema
// Idioma: Espa�ol
// Especificaci�n: Am�rica Latina - Bolivia
/////////////////////////////////////////////
/*
@package Menu
@description Generador de menus
*/

/**
 * Clase que genera un menu y lo prepara para impresion en pantalla
 *
 */
class Menu {
	/**
     * Contiene el nombre del menu en una cadena de texto
     *
     * @var string
     */
	var $name;
	/**
     * Contiene a todos los elemento del menu
     * Se puede llamarlos dir�ctamente desde aqui, y su estructura es la siguiente.
     * $this->items[$n]['name']
     * $this->items[$n]['href']
     * $this->items[$n]['target']
     * $this->items[$n]['tipo']
     *
     * @var array
     */
	var $items;
	/**
     * Define el icono o el texto de apertura del menu
     * Es el que se mostrar� en la pantalla, no tiene valor de uso
     *
     * @var string
     */
	var $open;
	/**
     * Define el icono o el texto de cierre del menu
     * Es el que se mostrar� en la pantalla, no tiene valor de uso
     *
     * @var string
     */
	var $closed;
	/**
     * Espacio o sangria que se utiliza, tambi�n se puede usar un relleno o imagen
     *
     * @var string
     */
	var $indent;

	/**
     * Contructor
     * Permite inicializar el objeto y llenar la informaci�n b�sica del menu
     *
     * @param string $name
     * @param string $open
     * @param string $closed
     * @param string $indent
     */
	function Menu($name,
	$open = '(-)',
	$closed = '(+)',
	$indent = '&nbsp; &nbsp; '
	)
	{
		$this->items  = array();
		$this->name   = $name;
		$this->open   = $open;
		$this->closed = $closed;
		$this->indent = $indent;
	}

	/**
     * Adiciona un elemento al menu
     * Se debe especificar el destino del menu en $target
     *
     * @param string $name
     * @param string $href
     * @param string $target
     * @param string $tipo
     * @param integer $id_menu
     */
	function add($name, $href = "", $target = "", $tipo = "", $id_menu = "", $funcion = "", $nombre_categoria = "") {
		$n = count($this->items);

		if (is_object($name)) {
			$this->items[$n] = $name;
		} else {
			$this->items[$n]['name'] = $name;
			$this->items[$n]['href'] = $href;
			$this->items[$n]['target'] = $target;
			$this->items[$n]['tipo'] = $tipo;
			$this->items[$n]['id_menu'] = $id_menu;
			$this->items[$n]['funcion'] = $funcion;
			$this->items[$n]['nombre_categoria'] = $nombre_categoria;
		}
	}

	/**
     * Funcion que muestra el menu
     * El par�metro $nest repite el Ident o relleno el n�mero de veces que se le indique
     *
     * @param int $nest
     */
	function show($nombre_categoria) {
		$urlname = strtr($this->name, ' ', '_');
		$indent = '';
		global $$urlname;
		global $PHP_SELF;
		global $QUERY_STRING;

		/*
		if ($nest) {
			$indent = str_repeat($this->indent, $nest);
		}
		*/


		if (isset($urlname)) {
			//printf('<div><span><a href="%s?%s"></a></span>',
			printf('<div><span>%s</span>',$nombre_categoria);
			//$PHP_SELF,
			//ereg_replace("{$urlname}=&", '', $QUERY_STRING),
			//$this->name);

			while (list(,$item) = each($this->items)) {
				if (is_object($item)) {
					$item->show($nest + 1);
				} else {
					//Creaci�n del enlace men� usuario
					if($item['tipo']=="url"){
						$elemento = "http://" . $item['href'];
					}elseif($item['tipo']=="bloque"){
						$elemento = $PHP_SELF . "?menu=" . md5($item['id_menu']);
						if($item['funcion']){
							$elemento = $elemento . "&funcion=" . $item['funcion'];
						}
					}elseif($item['tipo']=="componente"){
						$elemento = $item['href'];
					}else {
					$elemento = $item['href'];
					}
					// Impresi�n general del vinculo
					printf('<a href="%s"%s>%s</a>',
					$elemento,
					(!empty($item['target']) ? ' target="' .
					$item['target'] . '"'
					: ''),
					$item['name']);
				}
			}
		printf('</div>');
		} else {
			printf('<a href="%s?%s=&%s">%s</a>',
			$PHP_SELF,
			$urlname, $QUERY_STRING,
			$this->name);
			//echo "\n";
		}
	}

	/**
     * Crear un menu haciendo uso de la base de datos
     * Si no se pone datos entonces asume por defecto al menu 'Defecto'
     * Devuelve el nombre de la posición del menu
     *
     * @param string $nombre
     * @return char(1)
     *
     */
	 
	function Llenar_menu($id_usuario){
		$D_menu = new D_menu();
		$D_menu2 = new D_menu();
		$D_menu2->buscar_solo_asignaciones($id_usuario);

		for($j=0; $j<$D_menu2->num_filas; $j++){
		//alerta($D_menu2->datos[$j]->nombre_categoria);
		$D_menu->Lista_elementos_menu($id_usuario, $D_menu2->datos[$j]->id_m_categoria);
		
			for ($i=0; $i< $D_menu->num_filas; $i++){
				//$this->add($D_menu->datos[$i]->id_menu . " -> " . $D_menu->datos[$i]->nombre,$D_menu->datos[$i]->url, "" ,$D_menu->datos[$i]->tipo, $D_menu->datos[$i]->id_menu,$D_menu->datos[$i]->funciones, $D_menu->datos[$i]->nombre_categoria);
				$this->add($D_menu->datos[$i]->nombre,$D_menu->datos[$i]->url, "" ,$D_menu->datos[$i]->tipo, $D_menu->datos[$i]->id_menu,$D_menu->datos[$i]->funciones, $D_menu->datos[$i]->nombre_categoria);
			}
		
		$this->show($D_menu2->datos[$j]->nombre_categoria);
		}
	}
	
	function Llenar_menu_from_dir($dir = "", $r_path = ""){
		if (is_dir($dir))
		{
			$d = scandir($dir);
			foreach($d as $file){
				if (strlen($file)>4 && substr($file, strlen($file) - 4) == ".php"){
					$name = substr($file, 0, strlen($file) - 4);
					$this->add(strtoupper(join(" ",split('_',$name))), "?opc_c=$r_path&opc_a=$name", "", "", 0);
				}
			}
			$this->show();
		}
		else 
			echo "Error al cargar el directorio !!<br>".$dir;
	}
	
}

/*
EJEMPLO DE USO 
$M2 = new Menu("Menu 1",'(-)','(+)');

$M2->add('Uno',"temp3.php");
$M2->add('Dos',"temp4.php");
$M2->show();
*/

?>
