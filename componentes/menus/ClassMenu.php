<?php
/**
 * Created by PhpStorm.
 * User: MARCOP
 * Date: 29/07/2019
 * Time: 0:37
 */

class ClassMenuElemento{
    var $id_menu;
    var $name;
    var $descripcion;
    var $url;
    var $funciones;
    var $orden;
    var $grupo;
    var $activo;
    var $tipo;
    var $id_m_categoria;
}
class ClassMenuCategoria
{
    var $id_m_categoria;
    var $nombre;
    var $descripcion;
    var $clase;
    var $menu_elementos = array();
}

class ClassMenu
{
    var $menu_Completo = array();
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
     * Define la primera etiqueda ul que será el contenedor principal de nuestro menu
     * por defecto: <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" data-pg-collapsed>
     * @var string
     */
    var $sidebar = "<ul class=\"navbar-nav bg-gradient-primary sidebar sidebar-dark accordion\" id=\"accordionSidebar\" data-pg-collapsed>";
    /**
     * Define el final del contener de nuestro menu
     * @var string
     */
    var $sidebar_fin = "</ul>";
    var $brand = "<a class=\"sidebar-brand d-flex align-items-center justify-content-center\" href=\"index.php\" data-pg-collapsed>
        <div class=\"sidebar-brand-icon rotate-n-15\">
            <i class=\"fas fa-laugh-wink\"></i>
        </div>
        <div class=\"sidebar-brand-text mx-3\">ADMINISTRADOR</div>
    </a>";
    /**
     * Define el divisor para cada
     * @var string
     */
    var $divider = "<hr class=\"sidebar-divider my-0\">";

    var $id_m_categoria_activa;

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
            //  AQUI VAN LAS CATEGORIAS

            $tempObj = new ClassMenuCategoria();
            $tempObj->id_m_categoria = $D_menu2->datos[$j]->id_m_categoria;
            $tempObj->nombre = $D_menu2->datos[$j]->nombre_categoria;
            $tempObj->descripcion = $D_menu2->datos[$j]->descripcion;
            $tempObj->clase = $D_menu2->datos[$j]->clase_categoria;
            $tempObj->menu_elementos = array();

            // Creao que va al final luego de haber llenado la ramificacion de MENU ELEMENTOS
            //$this->menu_Completo[$j] = $tempObj;

            $D_menu->Lista_elementos_menu($id_usuario, $D_menu2->datos[$j]->id_m_categoria);

            for ($i=0; $i< $D_menu->num_filas; $i++){
                $tmpMElem = new ClassMenuElemento();
                $tmpMElem->id_menu = $D_menu->datos[$i]->id_menu;
                $tmpMElem->name = $D_menu->datos[$i]->nombre;
                $tmpMElem->descripcion = $D_menu->datos[$i]->descripcion;
                $tmpMElem->url = $D_menu->datos[$i]->url;
                $tmpMElem->funciones = $D_menu->datos[$i]->funciones;
                $tmpMElem->orden = $D_menu->datos[$i]->orden;
                $tmpMElem->grupo = $D_menu->datos[$i]->grupo;
                $tmpMElem->activo = $D_menu->datos[$i]->activo;
                $tmpMElem->tipo = $D_menu->datos[$i]->tipo;
                $tmpMElem->id_m_categoria = $D_menu->datos[$i]->id_m_categoria;

                if(htmlspecialchars($_GET["menu"]) == md5($tmpMElem->id_menu)){
                    $this->id_m_categoria_activa = $D_menu->datos[$i]->id_m_categoria;
                }

                $tempObj->menu_elementos[$i] = $tmpMElem;
                // AQUI VAL LOS ELEMENTOS SUELTOS
                //$this->add($D_menu->datos[$i]->id_menu . " -> " . $D_menu->datos[$i]->nombre,$D_menu->datos[$i]->url, "" ,$D_menu->datos[$i]->tipo, $D_menu->datos[$i]->id_menu,$D_menu->datos[$i]->funciones, $D_menu->datos[$i]->nombre_categoria);
                //$this->add($D_menu->datos[$i]->nombre,$D_menu->datos[$i]->url, "" ,$D_menu->datos[$i]->tipo, $D_menu->datos[$i]->id_menu,$D_menu->datos[$i]->funciones, $D_menu->datos[$i]->nombre_categoria, $D_menu->datos[$i]->clase_categoria);
            }
            $this->menu_Completo[$j] = $tempObj;
            //$this->show($D_menu2->datos[$j]->nombre_categoria);
        }

        //return $this->menu_Completo;
        return $this->GenerarHtml();
    }

    public function GenerarHtml(){
        $resultado = "";
        $resultado = $resultado . $this->sidebar;
        $resultado = $resultado . $this->brand;
        $resultado = $resultado . $this->divider;

        for ($i=0; $i < count($this->menu_Completo); $i++){
            $ClaseCategoriaActual = $this->menu_Completo[$i];
            $resultado = $resultado . $this->Devolver_li_nav_item($ClaseCategoriaActual->id_m_categoria);
            //$resultado = $resultado . "<li class=\"nav-item\" data-pg-collapsed>
            $resultado = $resultado . "
        <a class=\"nav-link collapsed\" href=\"#\" data-toggle=\"collapse\" data-target=\"#collapse" . $i . "\" aria-expanded=\"true\" aria-controls=\"collapse" . $i . "\">";
            $resultado = $resultado . "<i class=\"" . $ClaseCategoriaActual->clase . "\"></i>";
            $resultado = $resultado . "<span>" . $ClaseCategoriaActual->nombre . "</span>";
            $resultado = $resultado . "</a>";

            $resultado = $resultado . "<div id=\"collapse" . $i . "\" class=\"collapse " . $this->Devolver_cat_activa($ClaseCategoriaActual->id_m_categoria) . "\" aria-labelledby=\"heading" . $i . "\" data-parent=\"#accordionSidebar\">";
                $resultado = $resultado . "<div class=\"bg-white py-2 collapse-inner rounded\">";
                for($j=0; $j < count($ClaseCategoriaActual->menu_elementos); $j++){
                    $ClaseItemSuelto = $ClaseCategoriaActual->menu_elementos[$j];
                    $resultado = $resultado . $this->Devolver_a_elemento($ClaseItemSuelto);
                    //$resultado = $resultado . "<a class=\"collapse-item\" href=\"" . $ClaseItemSuelto->url . "\">" . $ClaseItemSuelto->name . "</a>";
                }
            $resultado = $resultado . "</div>
        </div>
    </li>";

        }
        $resultado = $resultado . "<hr class=\"sidebar-divider d-none d-md-block\">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class=\"text-center d-none d-md-inline\" data-pg-collapsed>
        <button class=\"rounded-circle border-0\" id=\"sidebarToggle\"></button>
    </div>

        </ul>";
        return $resultado;
    }

    private function Devolver_cat_activa($id_m_categoria){
        $D_menu = new D_menu();
        //$D_menu->
        if($this->id_m_categoria_activa == $id_m_categoria){
            $classActiva = "show";
        }else{
            $classActiva = "";
        }
        return $classActiva;
    }

    private function Devolver_li_nav_item($id_m_categoria){
        //$D_menu = new D_menu();
        //$D_menu->
        if($this->id_m_categoria_activa == $id_m_categoria){
            $classActiva = "active";
        }else{
            $classActiva = "";
        }
        $resultado = "<li class=\"nav-item " . $classActiva . "\" data-pg-collapsed>";
        return $resultado;
    }

    private function Devolver_a_elemento($ItemSuelto){
        global $PHP_SELF;
        $elemento = "";
        if($ItemSuelto->tipo=="url"){
            $elemento = "http://" . $ItemSuelto->href;
        }elseif($ItemSuelto->tipo=="bloque"){
            $elemento = $PHP_SELF . "?menu=" . md5($ItemSuelto->id_menu);
            if($ItemSuelto->funciones){
                $elemento = $elemento . "&funcion=" . $ItemSuelto->funciones;
            }
        }elseif($ItemSuelto->tipo=="componente"){
            $elemento = $PHP_SELF . "?menu=" . md5($ItemSuelto->id_menu);
            //$elemento = $ItemSuelto->href;
        }else {
            $elemento = $PHP_SELF . "?menu=?";
            //$elemento = $item['href'];
        }
        // Impresi�n general del vinculo

        /*printf('<a href="%s"%s>%s</a>',
            $elemento,
            (!empty($item['target']) ? ' target="' .
                $item['target'] . '"'
                : ''),
            $item['name']);*/
        if(htmlspecialchars($_GET["menu"]) == md5($ItemSuelto->id_menu)){
            $classActiva = "active";
        }else{
            $classActiva = "";
        }
        return "<a class=\"collapse-item " . $classActiva ." \" href=\"" . $elemento . "\">" . $ItemSuelto->name . "</a>";
    }

}

