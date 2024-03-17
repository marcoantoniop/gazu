<?php
class ClassSaltar{
    var  $saltar_cuerpo = "no";
    var $saltar_menu = "no";

    public function Inicializa()
    {
        $this->saltar_menu = "no";
        $this->saltar_cuerpo = "no";
    }

    public function SaltarCuerpo(){
        $this->saltar_cuerpo = true;

    }

    public static function SaltarMenu(){
        $_SESSION['SaltarMenu'] = true;
        //$this->saltar_menu = true;
    }

    public static function DeboSaltaMenu(){
        return $_SESSION['SaltarMenu'];
    }
}
?>