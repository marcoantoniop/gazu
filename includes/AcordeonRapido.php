<?php


class AcordeonRapido
{
public $titulo;
public $cuerpo;
//public entidadTablaElemento $tablaElemento;
public array $tablaElemento = array();


    public function setTitulo($titulo)
    {
        $this->titulo = $titulo . "</summmary>";
    }

    public function addCuerpo($cuerpo){
        $this->cuerpo = $this->cuerpo . $cuerpo;
    }

    public function addElemento($numero, $elemento, $valor){
        $objE = new entidadTablaElemento();
        $objE->valores($numero,$elemento,$valor);
        array_push($this->tablaElemento,$objE);
    }
    public function addElemento2($numero, $elemento, $valor,$id_control){
        $objE = new entidadTablaElemento();
        $objE->valores2($numero,$elemento,$valor,$id_control);
        array_push($this->tablaElemento,$objE);
    }

    public function generarTablaElemento(){
        $tabla = "";
        $inicio = "<h3>Reconocimiento automático</h3>
                <table class='table table-striped'>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Elem.</th>
                        <th>Valor</th>
                    </tr>
                    </thead>
                    <tbody>";
        $fin = "</tbody>";
        foreach ($this->tablaElemento as $obE){
            $tabla = $tabla . "<tr>
                        <th scope='row'>" . $obE->num . "</th>
                        <td>" . $obE->elemento . "</td>
                        <td>" . $obE->valor . "</td>
                    </tr>";
        }

        return $inicio . $tabla . $fin;

    }
    public function generarTablaElemento2(){
        $tabla = "";
        $inicio = "<h3>Corregir y revisar</h3>
                <table class='table table-striped'>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Elem.</th>
                        <th>Valor</th>
                        <th>Ep.</th>
                    </tr>
                    </thead>
                    <tbody>";
        $fin = "</tbody>";
        foreach ($this->tablaElemento as $obE){
            $tabla = $tabla . "<tr>
                        <th scope='row'>" . $obE->num . "</th>
                        <td>" . $obE->elemento . "</td>
                        <td>
                            <div id='div_fe_" . $obE->id_control . "'>" . $obE->valor . "</div>
                        </td>
                        <td>
                        <div id='div_ce_" . $obE->id_control . "'>
                        <button type='button' class='btn btn-warning' onclick='edit_ce($obE->id_control)' >Editar</button>
                        </div>
                        </td>
                    </tr>";
        }

        return $inicio . $tabla . $fin;

    }

    public function resultadoAcordeon(){
        $resultado = "<details>
                        <summmary>" . $this->titulo . "</summmary>
                        " . $this->cuerpo . "
                        </details>";
        return $resultado;
    }

    public function maquetaBase($id_cliente){
        $maqueta = "<details>
    
    <div class=\"container-fluid\">
        <div class=\"row\">
            <div class=\"col-md-7\" id='div_elem_$id_cliente'>
                
                </table>
            </div>
            <div class=\"col-md-5\">
                <div class=\"row\">
                    <div>
                        <div class=\"thumbnail\">
                        <div id='img_t_" . $id_cliente . "'></div>
                            
                            <div class=\"caption\">
                                <p>Para Verificar los datos puede ver la imagen del acta completa</p>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</details>";
    return $maqueta;
    }
    public function maquetaBase2($id_cliente){
        $maqueta = "<details>
    
    <div class=\"container-fluid\">
        <div class=\"row\">
            <div class=\"col-md-7\" id='div_elem_$id_cliente'>
                
                </table>
            </div>
            <div class=\"col-md-5\">
                <div class=\"row\">
                    <div>
                        <div class=\"thumbnail\">
                        <div id='img_t_" . $id_cliente . "'></div>
                            
                            <div class=\"caption\">
                                <p>Para Verificar los datos puede ver la imagen del acta completa</p>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</details>";
    return $maqueta;
    }
}

class entidadTablaElemento{
    public $num;
    public $elemento;
    public $valor;
    public $id_control;

    public function valores($num, $elemento, $valor){
        $this->num = $num;
        $this->elemento = $elemento;
        $this->valor = $valor;
    }
    public function valores2($num, $elemento, $valor, $id_control){
        $this->num = $num;
        $this->elemento = $elemento;
        $this->valor = $valor;
        $this->id_control = $id_control;
    }
}
?>
