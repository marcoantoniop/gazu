<?php
/////////////////////////////////////////////
// Archivo general de temas Clase Tema
// Idioma: Español
// Especificación: Am�rica Latina - Bolivia
/////////////////////////////////////////////


/**
 * Clase que se encarga de la seleccion del tema actual de la base de datos
 *
 */
class tema extends conex {
	var $arch_tema;
	var $dir;

	function tema(){
		// Definimos el tema actual con el que se est� trabajando
		//$this->select("select tema from config");
		$this->arch_tema = 'azul';//$this->datos[0]->tema;
		$this->arch_tema = 'botstr';//$this->datos[0]->tema;
		$this->arch_tema = 'sb';//$this->datos[0]->tema;
		//$this->arch_tema = 'blur';//$this->datos[0]->tema;
	}

}



?>