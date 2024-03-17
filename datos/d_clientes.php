<?php


class d_clientes extends conex
{
    function listar_cliente(){
        $sql = "select * from cliente";
        $this->select($sql);
    }

    /**
     * @param $id_cliente int
     */
    function buscar_cliente($id_cliente){
        $sql = sprintf("select * from cliente where id_cliente = %d", $id_cliente);
        $this->select($sql);
    }

    /**
     * @param $id_cliente integer
     */
    function buscar_analisis_final($id_cliente){
        $sql = sprintf("SELECT
              analisis.id_analisis,
              images.img_name,
              images.id_image,
              cliente.estado
            FROM cliente
              INNER JOIN images
                ON cliente.imagen_procesada = images.id_image
              INNER JOIN analisis
                ON analisis.id_image = images.id_image WHERE cliente.id_cliente = %d", $id_cliente);
        $this->select($sql);
    }

    function actualizar_estado($id_cliente, $estado){
        $sql = sprintf("UPDATE cliente
            SET estado = %s WHERE id_cliente = %s", $estado, $id_cliente);
        $this->actualizar($sql);
    }
}