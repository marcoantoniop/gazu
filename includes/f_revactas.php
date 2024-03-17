<?php
//include("../componentes/ajax/TinyAjax.php");
include_once "includes/ClassValidador.php";
include_once 'includes/Thumb.php';

/**
 * Primero creamos la funci�n a usar
 * @example function evento($params){}
 */
function procesar($id_cliente)
{
    $res = new TinyAjaxBehavior();
    include_once 'datos/d_clientes.php';
    include_once 'datos/d_actas.php';
    include_once 'datos/d_control_elemento.php';
    include_once 'includes/AcordeonRapido.php';

    $etiqueta = "class-" . $id_cliente;


    $D_actas = new d_actas();
    $D_clientes = new d_clientes();
    $D_control_e = new d_control_elemento();
    $D_clientes->buscar_analisis_final($id_cliente);
    $id_image = $D_clientes->datos[0]->id_image;
    $img_name = $D_clientes->datos[0]->img_name;
    $id_analisis = $D_clientes->datos[0]->id_analisis;
    $estado = $D_clientes->datos[0]->estado;

    if ($estado == 0) {

        $thumb = new Thumb();
        $thumb->loadImage('../archivos_cargados/' . $img_name);
        $thumb->resize(250, 'width');
        $thumb->save('../archivos_cargados/thumb/' . $img_name, 100);
        $miniatura = "<a href='../archivos_cargados/" . $img_name . "' target='_blank'><img src='../archivos_cargados/thumb/" . $img_name . "' /></a>";

        $acc_1 = new AcordeonRapido();
        $res->add(TabInnerHtml::getBehavior($etiqueta, $acc_1->maquetaBase($id_cliente)));
        $acc_1->setTitulo("Listando elementos<br>");
        $D_actas->listar_acta_elemento_orden();
        $lista_e = "";
        $Datmp = new d_actas();
        for ($i = 0; $i < $D_actas->num_filas; $i++) {
            $mostrar = "";
            $Datmp->buscar_analisis_detalle_ae($id_cliente, $D_actas->datos[$i]->id_ae);
            //$mostrar = $i + 1 . "- " . $D_actas->datos[$i]->nombre_elemento . " -> ";
            //$mostrar = $i + 1 . "- " . $D_actas->datos[$i]->nombre_elemento . " -> ";
            $cadena_detalle_elemento = "";
            for ($j = 0; $j < $Datmp->num_filas; $j++) {
                $cadena_detalle_elemento = $cadena_detalle_elemento . " " . $Datmp->datos[$j]->descripcion;
            }
            $cadena_detalle_elemento = ClassValidador::limpiarTipoDato($D_actas->datos[$i]->contiene, $cadena_detalle_elemento);
            //$acc_1->addCuerpo($mostrar . $cadena_detalle_elemento . "<br>");
            $acc_1->addElemento($i + 1, $D_actas->datos[$i]->nombre_elemento, $cadena_detalle_elemento);
            //$res->add(TabInnerHtmlAppend::getBehavior($etiqueta,"ok"));
            //$res->add(TabInnerHtml::getBehavior($etiqueta,"ok"));
            $D_control_e->nuevo_control_elemento($id_analisis, $D_actas->datos[$i]->id_ae, $cadena_detalle_elemento, 0, "");
        }
        /**
         * ACTUALIZA ESTADO DEL CLIENTE
         * -1 - Eliminado
         * 0 - Solo procesado basico
         * 1 - Procesado automático
         * 2 - Pendiente
         * 3 - Verificado y terminado
         */
        $D_clientes->actualizar_estado($id_cliente, 1);
        //$res->add(TabInnerHtml::getBehavior($etiqueta,$acc_1->resultadoAcordeon()));
        $res->add(TabInnerHtml::getBehavior('img_t_' . $id_cliente, $miniatura));
        $res->add(TabInnerHtml::getBehavior('div_elem_' . $id_cliente, $acc_1->generarTablaElemento()));
        //$res->add(TabInnerHtml::getBehavior('div_badge_' . $id_cliente,"Procesado automático"));
        $res->add(TabInnerHtml::getBehavior('div_badge_' . $id_cliente, "<div class='badge badge badge-info'>Procesado automático</div>"));
        //$res->add(TabInnerHtmlAppend::getBehavior($etiqueta,$acc_1->resultadoAcordeon()));

        //$res->add(TabInnerHtml::getBehavior($etiqueta,"ok"));
    }else{
        $res->add(TabInnerHtml::getBehavior($etiqueta, "<h2>Proceso automático completado, vaya al boton Mostrar Detalles para refinar y obtener reportes</h2>"));
    }
    return $res->getString();
}
function administrar($id_cliente){
    $res = new TinyAjaxBehavior();
    include_once 'datos/d_clientes.php';
    include_once 'includes/AcordeonRapido.php';
    include_once 'datos/d_control_elemento.php';
    $D_clientes = new d_clientes();
    $D_clientes2 = new d_clientes();
    $D_control_e = new d_control_elemento();
    $acc = new AcordeonRapido();
    $D_clientes->buscar_cliente($id_cliente);
    $D_clientes2->buscar_analisis_final($id_cliente);
    $etiqueta = "class-" . $id_cliente;
    $res->add(TabInnerHtml::getBehavior($etiqueta, $acc->maquetaBase2($id_cliente)));
    if($D_clientes->num_filas == 1){
        if($D_clientes->datos[0]->estado == 0){
            $res->add(TabAlert::getBehavior("Primero debe iniciar el proceso automático"));
            $res->add(TabInnerHtml::getBehavior($etiqueta,"Senecesita iniciar el proceso automático"));
        }

        if($D_clientes->datos[0]->estado == 1){
            /**
             * -1 - Eliminado
            0 - Solo procesado basico
            1 - Procesado automático
            2 - Pendiente
            3 - Verificado y terminado
             */
            $D_control_e->buscar_control_elemento_cliente($id_cliente);
            for($i=0; $i < $D_control_e->num_filas; $i++){
                $acc->addElemento2($i+1,$D_control_e->datos[$i]->nombre_elemento,$D_control_e->datos[$i]->resultado,$D_control_e->datos[$i]->id_control);
            }
        }
    }


    $img_name = $D_clientes2->datos[0]->img_name;
    $miniatura = "<div><a href='../archivos_cargados/" . $img_name . "' target='_blank'><img src='../archivos_cargados/thumb/" . $img_name . "' /></a></div>";

    //echo $pdocrud->dbTable("usuario")->render();
    $res->add(TabInnerHtml::getBehavior($etiqueta,$miniatura . $acc->generarTablaElemento2()));
    //$res->add(TabSetValue::getBehavior("etiqueta",$parametro1));

    //$res->add(TabInnerHtml::getBehavior($etiqueta,"ok"));
    return $res->getString();
}

function ocultar($id_cliente){
    $res = new TinyAjaxBehavior();
    //$res->add(TabSetValue::getBehavior("etiqueta",$parametro1));
    $etiqueta = "class-" . $id_cliente;
    $res->add(TabInnerHtml::getBehavior($etiqueta,""));
    return $res->getString();
}
function edit_ce($id_control){
    $res = new TinyAjaxBehavior();
    include_once 'datos/d_control_elemento.php';
    $etiqueta = "div_fe_" . $id_control;
    $etiqueta2 = "div_ce_" . $id_control;
    $D_ce = new d_control_elemento();
    $D_ce->buscar_control_elemento_id($id_control);
    $tag_input = '"it_' . $id_control . '"';
    //$res->add(TabSetValue::getBehavior("etiqueta",$parametro1));
    $botones = "<button type='button' class='btn btn-success' onclick='recibir($id_control)'>Guardar</button>
                            <button type='button' onclick='mostrar_div($id_control)' class='btn btn-danger'>Cancelar</button>";
    $e_input = "<input type='text' id='it_" . $id_control ."' value='" . $D_ce->datos[0]->resultado . "'>";
    $res->add(TabInnerHtml::getBehavior($etiqueta,$e_input));
    $res->add(TabInnerHtml::getBehavior($etiqueta2,$botones));
    return $res->getString();
}
function actualiza_ce($id_control,$tag_input){
    $res = new TinyAjaxBehavior();
    include_once 'datos/d_control_elemento.php';
    $etiqueta = "div_fe_" . $id_control;
    $etiqueta2 = "div_ce_" . $id_control;
    $D_ce = new d_control_elemento();

    $D_ce->actualizar_control_elemento($id_control,$tag_input);
    $D_ce->buscar_control_elemento_id($id_control);
    //$res->add(TabSetValue::getBehavior("etiqueta",$parametro1));
    $botones = "<button type='button' class='btn btn-warning' onclick='edit_ce($id_control)' >Editar</button>";

    //$e_input = "<input type='text' id='it_" . $id_control ."' value='" . $D_ce->datos[0]->resultado . "'>";
    $e_input = $D_ce->datos[0]->resultado;
    $res->add(TabInnerHtml::getBehavior($etiqueta,$e_input));
    $res->add(TabInnerHtml::getBehavior($etiqueta2,$botones));

   mostrar_div($id_control);
    return $res->getString();
}
function mostrar_div($id_control){
    $res = new TinyAjaxBehavior();
    include_once 'datos/d_control_elemento.php';
    $etiqueta = "div_fe_" . $id_control;
    $etiqueta2 = "div_ce_" . $id_control;
    $D_ce = new d_control_elemento();
    $D_ce->buscar_control_elemento_id($id_control);
    //$res->add(TabSetValue::getBehavior("etiqueta",$parametro1));
    $botones = "<button type='button' class='btn btn-warning' onclick='edit_ce($id_control)' >Editar</button>";
    $e_input = $D_ce->datos[0]->resultado;
    $res->add(TabInnerHtml::getBehavior($etiqueta,$e_input));
    $res->add(TabInnerHtml::getBehavior($etiqueta2,$botones));
    return $res->getString();
}

$ajax = new TinyAjax();
$ajax->exportFunction("procesar",array("id_cliente"));
$ajax->exportFunction("administrar",array("id_cliente"));
$ajax->exportFunction("ocultar",array("id_cliente"));
$ajax->exportFunction("edit_ce",array("id_control"));
$ajax->exportFunction("mostrar_div",array("id_control"));
$ajax->exportFunction("actualiza_ce",array("id_control","tag_input"));
$ajax->process();
$ajax->drawJavaScript();
?>