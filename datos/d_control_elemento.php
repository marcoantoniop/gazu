<?php


class d_control_elemento extends conex
{
    /**
     * @param $id_analisis integer
     * @param $id_ae integer
     * @param $resultado string
     * @param $estado integer
     * @param $comentario string
     */
    function nuevo_control_elemento($id_analisis, $id_ae, $resultado, $estado, $comentario){
        if($resultado == ""){
            /**
             * PARA ESTADO
             * -1 - Eliminado
            0 - Vacio
            1 - Revisado
            2 - Pendiente
            3 - Verificado y terminado
             */
            $estado = 0;
        }else{
            $estado = 1;
        }
        $sql = sprintf("INSERT INTO control_elemento (id_analisis, id_ae, resultado, estado, comentario)
  VALUES (%s, %s, %s, %s, %s)", $id_analisis, $id_ae,"'" . $resultado . "'", $estado,"'" . $comentario . "'");
        $this->insert($sql);
    }

    function buscar_control_elemento_cliente($id_cliente){
        $sql = "SELECT
  acta_elemento.nombre_elemento,
  control_elemento.resultado,
  control_elemento.estado,
  control_elemento.comentario,
  control_elemento.id_control,
  cliente.id_cliente
FROM acta_elemento
  INNER JOIN control_elemento
    ON acta_elemento.id_ae = control_elemento.id_ae
  INNER JOIN analisis
    ON analisis.id_analisis = control_elemento.id_analisis
  INNER JOIN cliente
    ON cliente.id_cliente = analisis.id_cliente
WHERE cliente.id_cliente = $id_cliente";
        $this->select($sql);
    }

    function buscar_control_elemento_id($id_control){
        $sql = "select * from control_elemento 
            where id_control = $id_control";
        $this->select($sql);
    }

    function actualizar_control_elemento($id_control, $resultado){
        $sql = "UPDATE control_elemento
SET resultado = '" . $resultado . "'
WHERE id_control = $id_control";
        $this->actualizar($sql);

    }
}