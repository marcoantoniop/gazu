<?php


class d_actas extends conex
{
    function listar_acta_tipo_elemento()
    {
        $sql = "select * from acta_tipo_elemento";
        $this->select($sql);
    }

    /**
     * @param $nombre_elemento
     * @param $numero
     * @param $id_te
     * @param $pos_x
     * @param $pos_y
     * @param $ancho
     * @param $alto
     * @param $img_ancho
     * @param $img_alto
     */
    function nuevo_acta_elemento($nombre_elemento, $numero, $id_te, $pos_x, $pos_y, $ancho, $alto, $img_ancho, $img_alto)
    {
        $sql_cad = "INSERT INTO acta_elemento(nombre_elemento, numero, id_te, pos_x, pos_y, ancho, alto, img_ancho, img_alto)
            VALUES ('%s',%d,%d,%d,%d,%d,%d,%d,%d)";
        $sql = sprintf($sql_cad, $nombre_elemento, $numero, $id_te, $pos_x, $pos_y, $ancho, $alto, $img_ancho, $img_alto);

        $this->insert($sql);
    }

    /**
     * Listar Tabla Actas_elemento
     */
    function listar_actas_elemento()
    {
        $sql = "SELECT
          acta_elemento.id_ae,
          acta_elemento.nombre_elemento,
          acta_elemento.numero,
          acta_elemento.pos_x,
          acta_elemento.ancho,
          acta_elemento.alto,
          acta_elemento.img_ancho,
          acta_elemento.img_alto,
          acta_tipo_elemento.nombre AS tipo_elemento,
          acta_tipo_elemento.id_te
        FROM acta_tipo_elemento
          INNER JOIN acta_elemento
            ON acta_tipo_elemento.id_te = acta_elemento.id_te
        ORDER BY acta_elemento.numero";
        $this->select($sql);
    }

    function listar_acta_elemento_orden(){
        $sql = "SELECT
          acta_elemento.*
        FROM acta_elemento
        ORDER BY acta_elemento.numero, acta_elemento.nombre_elemento";
        $this->select($sql);
    }

    /**
     * @param $id_cliente integer
     * @param $acta_elemento integer
     */
    function buscar_analisis_detalle_ae($id_cliente, $id_ae){
        $sql = "SELECT
              cliente.imagen_procesada,
              cliente.id_cliente,
              images.img_name,
              analisis_detalle.id_at,
              analisis_detalle.descripcion,
              acta_elemento.nombre_elemento,
              acta_elemento.id_ae
            FROM analisis
              INNER JOIN cliente
                ON analisis.id_cliente = cliente.id_cliente
              INNER JOIN images
                ON images.id_image = cliente.imagen_procesada
              INNER JOIN analisis_detalle
                ON analisis_detalle.id_analisis = analisis.id_analisis
              INNER JOIN acta_elemento
                ON acta_elemento.id_ae = analisis_detalle.id_ae
            WHERE cliente.id_cliente = $id_cliente
            AND acta_elemento.id_ae = $id_ae";
        $this->select($sql);
    }
}