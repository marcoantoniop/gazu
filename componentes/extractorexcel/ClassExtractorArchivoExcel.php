<?php
    /**
     * Created by PhpStorm.
     * User: MARCOP
     * Date: 24/6/2019
     * Time: 02:58 AM
     */

    //include_once ('componentes/PdfToText/PdfToText.php');
    //include_once ('componentes/PdfToText/PdfToText.php');
    require_once "componentes/leer_excel/vendor/autoload.php";
    include_once "includes/ClassValidador.php";
    include_once "datos/conex.php";
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class ClassExtractorArchivoExcel
    {
        public $carpeta;
        public $archivo;
        public $total_hojas;
        public $texto;
        public $error_sql;
        public $arreglo;
        public $arregloOrdenado;
        public $lim;
        /*
         public function __construct($carpeta, $archivo)
         {
             $this->carpeta = $carpeta;
             $this->archivo = $archivo;
         }
        */

         public function extraerArchivo(){


             $texto = "";
             $miArchivoo = "adjuntos_excel/" . $this->carpeta . "/" . $this->archivo;
             $documento = IOFactory::load($miArchivoo);
             $this->total_hojas = $documento->getSheetCount();

             # Iterar hoja por hoja
             for ($indiceHoja = 0; $indiceHoja < $this->total_hojas; $indiceHoja++) {
                 # Obtener hoja en el índice que vaya del ciclo
                 $hojaActual = $documento->getSheet($indiceHoja);
                 //$texto = $texto . "<h3>Vamos en la hoja con índice $indiceHoja</h3>";
                 # Calcular el máximo valor de la fila como entero, es decir, el
                 # límite de nuestro ciclo
                 $numeroMayorDeFila = $hojaActual->getHighestRow(); // Numérico
                 $letraMayorDeColumna = $hojaActual->getHighestColumn(); // Letra
                 # Convertir la letra al número de columna correspondiente
                 $numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
                 # Encabezados
                 $celda = $hojaActual->getCell("H1");
                 $turno = $celda->getValue();
                 $turno = ClassValidador::limpiarTurno($turno);

                 $celda = $hojaActual->getCell("A2");
                 $unidad_educativa = $celda->getValue();

                 $celda = $hojaActual->getCell("D2");
                 $sie = $celda->getValue();
                 $sie = ClassValidador::limpiarSie($sie);
                 //$sie = substr($sie,4);


                 $celda = $hojaActual->getCell("F2");
                 $curso = $celda->getValue();

                 $celda = $hojaActual->getCell("G2");
                 $paralelo = $celda->getValue();


                 # Iterar filas con ciclo for e índices
                 for ($indiceFila = 6; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
                     $celda = $hojaActual->getCellByColumnAndRow(1, $indiceFila);
                     $num = $celda->getValue();
                     $celda = $hojaActual->getCellByColumnAndRow(2, $indiceFila);
                     //$rude = $celda->getCalculatedValue();
                     $rude = $celda->getFormattedValue();
                     $rude = ClassValidador::limpiarRude($rude);
                     //$rude = ClassValidador::eliminarEspacios($rude);
                     //$rude = $celda->getValue();

                     $celda = $hojaActual->getCellByColumnAndRow(3, $indiceFila);
                     $ape_pat = $celda->getValue();

                     $celda = $hojaActual->getCellByColumnAndRow(4, $indiceFila);
                     $ape_mat = $celda->getValue();

                     $celda = $hojaActual->getCellByColumnAndRow(5, $indiceFila);
                     $nombre = $celda->getValue();

                     $celda = $hojaActual->getCellByColumnAndRow(6, $indiceFila);
                     $ci = $celda->getValue();
                     $ci = ClassValidador::eliminarCiExpedido($ci);

                     $celda = $hojaActual->getCellByColumnAndRow(7, $indiceFila);
                     $genero = $celda->getValue();

                     if ($rude != "") {


                     $texto = $texto .
                         $num . ";" .
                         $rude . ";" .
                         $ape_pat . " " . $ape_mat . " " . $nombre . ";" .
                         $ci . ";" .
                         $genero . ";" .
                         $sie . ";" .
                         substr($paralelo,10) . ";" .
                         $turno . ";" .
                         substr($unidad_educativa,13) . ";" .
                         "<br>";
                    }
                 }
             }
            return $texto;
         }

        public function extraerArchivoSQL(){
            $texto = "";
            $this->error_sql = "";
            $miArchivoo = "adjuntos_excel/" . $this->carpeta . "/" . $this->archivo;
            $documento = IOFactory::load($miArchivoo);
            $this->total_hojas = $documento->getSheetCount();

            # Iterar hoja por hoja
            for ($indiceHoja = 0; $indiceHoja < $this->total_hojas; $indiceHoja++) {
                # Obtener hoja en el índice que vaya del ciclo
                $hojaActual = $documento->getSheet($indiceHoja);
                //$texto = $texto . "<h3>Vamos en la hoja con índice $indiceHoja</h3>";
                # Calcular el máximo valor de la fila como entero, es decir, el
                # límite de nuestro ciclo
                $numeroMayorDeFila = $hojaActual->getHighestRow(); // Numérico
                $letraMayorDeColumna = $hojaActual->getHighestColumn(); // Letra
                # Convertir la letra al número de columna correspondiente
                $numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
                # Encabezados
                $celda = $hojaActual->getCell("H1");
                $turno = $celda->getValue();
                $turno = ClassValidador::limpiarTurno($turno);

                $celda = $hojaActual->getCell("A2");
                $unidad_educativa = $celda->getValue();

                $celda = $hojaActual->getCell("D2");
                $sie = $celda->getValue();
                $sie = ClassValidador::limpiarSie($sie);

                $celda = $hojaActual->getCell("F2");
                $curso = $celda->getValue();

                $celda = $hojaActual->getCell("G2");
                $paralelo = $celda->getValue();


                # Iterar filas con ciclo for e índices
                for ($indiceFila = 6; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
                    $celda = $hojaActual->getCellByColumnAndRow(1, $indiceFila);
                    $num = $celda->getValue();
                    $celda = $hojaActual->getCellByColumnAndRow(2, $indiceFila);
                    //$rude = $celda->getCalculatedValue();
                    $rude = $celda->getFormattedValue();
                    $rude = ClassValidador::limpiarRude($rude);
                    //$rude = $celda->getValue();

                    $celda = $hojaActual->getCellByColumnAndRow(3, $indiceFila);
                    $ape_pat = $celda->getValue();

                    $celda = $hojaActual->getCellByColumnAndRow(4, $indiceFila);
                    $ape_mat = $celda->getValue();

                    $celda = $hojaActual->getCellByColumnAndRow(5, $indiceFila);
                    $nombre = $celda->getValue();

                    $nombre_completo = $ape_pat . " " . $ape_mat  . " " .  $nombre;
                    $nombre_completo = str_replace("'",'', $nombre_completo);


                    $celda = $hojaActual->getCellByColumnAndRow(6, $indiceFila);
                    $ci = $celda->getValue();
                    $ci = ClassValidador::eliminarCiExpedido($ci);

                    $celda = $hojaActual->getCellByColumnAndRow(7, $indiceFila);
                    $genero = $celda->getValue();

                    if ($rude != "") {
                        $texto = $texto .
                            "INSERT INTO estudiantes
                                (
                                  rude
                                  ,ci
                                 ,nombre
                                 ,genero
                                 ,sie
                                 ,paralelo
                                 ,turno
                                 ,u_educativa
                                )
                                VALUES
                                (
                                  '$rude'
                                  ,'$ci'
                                 ,'$nombre_completo'
                                 ,'$genero'
                                 ,'$sie'
                                 ,'" . substr($paralelo,10) . "'
                                 ,'$turno'
                                 ,'" .  substr($unidad_educativa,13) . "'
                                );" .
                            "<br>";
                        /*
                        $texto = $texto .
                            $num . ";" .
                            $rude . ";" .
                            $ape_pat . " " . $ape_mat . " " . $nombre . ";" .
                            $ci . ";" .
                            $genero . ";" .
                            substr($sie,4) . ";" .
                            substr($paralelo,10) . ";" .
                            substr($turno,7) . ";" .
                            substr($unidad_educativa,13) . ";" .
                            "<br>";
                        */
                    }
                }
            }
            return $texto;
        }

        public function devolverCsv(){
            $texto = "";
            $sie = $this->arreglo[9];
            $puntero = 32;
            $contador = 0;
            $miId = 1;
            for($i = 30; $i < $this->lim; $i++){
                $contador = $contador +1;
                $idArreglo = $this->arreglo[$i];
                if(($idArreglo == $miId) && (is_numeric($idArreglo))){
                    $texto = $texto .
                      $this->arreglo[$i] . ";" .
                        $this->arreglo[$i+1] . ";" .
                        $this->arreglo[$i+2] . ";" .
                        $this->arreglo[$i+3] . ";" .
                        $this->arreglo[$i+4] . $this->arreglo[$i+5] . ";" .
                        $this->arreglo[$i+6] . ";" .
                        $this->arreglo[$i+7] . ";" .
                        $this->arreglo[$i+8] . ";" .
                        $this->arreglo[$i+9] . ";" .
                        $sie . ";" . "<br>"
                    ;
                    $miId = $miId +1;
                    $contador = 0;
                }
                //$resultado = $resultado . $i . " --> " . $miCadenaArreglo[$i] . "<br>";
            }
            return $texto;
        }

         public function devolverTabla(){
             $texto = "<table width=\"100%\" border=\"1\">
                          <tbody>
                            <tr>
                              <td>SIE: " . $this->arreglo[9] . "</td>
                              <td>Unidad Educativa: " . $this->arreglo[11] . "</td>
                            </tr>
                            <tr>
                              <td>NIVEL: " . $this->arreglo[13] . "</td>
                              <td>Gestion: " . $this->arreglo[15] . "</td>
                            </tr>
                            <tr>
                              <td>Grado: " . $this->arreglo[17] . "</td>
                              <td>Paralelo: " . $this->arreglo[19] . "</td>
                            </tr>
                          </tbody>
                        </table>";
             $texto = "<table width=\"100%\" border=\"1\">
                          <tbody>
                            <tr>
                              <th scope=\"col\">N.</th>
                              <th scope=\"col\">Rude</th>
                              <th scope=\"col\">Nombre Completo</th>
                              <th scope=\"col\">Sexo</th>
                              <th scope=\"col\">Fecha N</th>
                              <th scope=\"col\">Departamento</th>
                              <th scope=\"col\">Provincia</th>
                              <th scope=\"col\">Localidad</th>
                              <th scope=\"col\">Matricula</th>
                              <th scope=\"col\">SIE</th>
                            </tr>
                        ";
             $sie = $this->arreglo[9];
             $puntero = 32;
             $contador = 0;
             $miId = 1;
             for($i = 30; $i < $this->lim; $i++){
                 $contador = $contador +1;
                 $idArreglo = $this->arreglo[$i];
                 if(($idArreglo == $miId) && (is_numeric($idArreglo))){
                     $texto = $texto . "
                     <tr>
                              <td>" . $this->arreglo[$i] . "</td>
                              <td>" . $this->arreglo[$i+1] . "</td>
                              <td>" . $this->arreglo[$i+2] . "</td>
                              <td>" . $this->arreglo[$i+3] . "</td>
                              <td>" . $this->arreglo[$i+4] . $this->arreglo[$i+5] . "</td>
                              <td>" . $this->arreglo[$i+6] . "</td>
                              <td>" . $this->arreglo[$i+7] . "</td>
                              <td>" . $this->arreglo[$i+8] . "</td>
                              <td>" . $this->arreglo[$i+9] . "</td>
                              <td>" . $sie . "</td>
                     </tr>
                     ";
                     $miId = $miId +1;
                     $contador = 0;
                 }


                 //$resultado = $resultado . $i . " --> " . $miCadenaArreglo[$i] . "<br>";
             }

             $texto = $texto . "</tbody>
                       </table>";
             return $texto;
         }

        public function extraerArchivoComparar(){



            $texto = "";
            $this->error_sql = "";
            $miArchivoo = "adjuntos_excel/" . $this->carpeta . "/" . $this->archivo;
            $documento = IOFactory::load($miArchivoo);
            $this->total_hojas = $documento->getSheetCount();

            # Iterar hoja por hoja
            for ($indiceHoja = 0; $indiceHoja < $this->total_hojas; $indiceHoja++) {
                # Obtener hoja en el índice que vaya del ciclo
                $hojaActual = $documento->getSheet($indiceHoja);
                //$texto = $texto . "<h3>Vamos en la hoja con índice $indiceHoja</h3>";
                # Calcular el máximo valor de la fila como entero, es decir, el
                # límite de nuestro ciclo
                $numeroMayorDeFila = $hojaActual->getHighestRow(); // Numérico
                $letraMayorDeColumna = $hojaActual->getHighestColumn(); // Letra
                # Convertir la letra al número de columna correspondiente
                $numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
                # Encabezados
                $celda = $hojaActual->getCell("H1");
                $turno = $celda->getValue();
                $turno = ClassValidador::limpiarTurno($turno);

                $celda = $hojaActual->getCell("A2");
                $unidad_educativa = $celda->getValue();
                $unidad_educativa = substr($unidad_educativa,13);
                $unidad_educativa = trim($unidad_educativa);
                //trim(preg_replace('/[\s\t\n\r\s]+/', ' ', $unidad_educativa));
                //$unidad_educativa = trim($unidad_educativa);

                $celda = $hojaActual->getCell("D2");
                $sie = $celda->getValue();
                $sie = ClassValidador::limpiarSie($sie);
                //$sie = substr($sie,4);


                $celda = $hojaActual->getCell("F2");
                $curso = $celda->getValue();

                $celda = $hojaActual->getCell("G2");
                $paralelo = $celda->getValue();


                # Iterar filas con ciclo for e índices
                for ($indiceFila = 6; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
                    $celda = $hojaActual->getCellByColumnAndRow(1, $indiceFila);
                    $num = $celda->getValue();
                    $celda = $hojaActual->getCellByColumnAndRow(2, $indiceFila);
                    //$rude = $celda->getCalculatedValue();
                    $rude = $celda->getFormattedValue();
                    $rude = ClassValidador::limpiarRude($rude);
                    //$rude = ClassValidador::eliminarEspacios($rude);
                    //$rude = $celda->getValue();

                    $celda = $hojaActual->getCellByColumnAndRow(3, $indiceFila);
                    $ape_pat = $celda->getValue();

                    $celda = $hojaActual->getCellByColumnAndRow(4, $indiceFila);
                    $ape_mat = $celda->getValue();

                    $celda = $hojaActual->getCellByColumnAndRow(5, $indiceFila);
                    $nombre = $celda->getValue();

                    $nombre_completo = $ape_pat . " " . $ape_mat  . " " .  $nombre;
                    $nombre_completo = str_replace("'",'', $nombre_completo);
                    $nombre_completo = str_replace('  ',' ', $nombre_completo);

                    $celda = $hojaActual->getCellByColumnAndRow(6, $indiceFila);
                    $ci = $celda->getValue();
                    $ci = ClassValidador::eliminarCiExpedido($ci);

                    $celda = $hojaActual->getCellByColumnAndRow(7, $indiceFila);
                    $genero = $celda->getValue();
                    $genero = preg_replace('/\s+/', ' ', $genero);
                    $genero = ClassValidador::eliminarEspacios($genero);



                    if ($rude != "") {
                        $conex = new conex();
                        //$conex->inicializa();

                        $sql = "SELECT
                              *
                            FROM estudiantes
                            WHERE rude = '$rude'";
                        $conex->select($sql);

                        if($conex->num_filas == 1){
                            /**
                             * COMPARAMOS REGISTROS
                             */
                            //$nombre_completo = $ape_pat . " " . $ape_mat . " " . $nombre;
                            $paralelo = substr($paralelo,10);
                            /*
                            $error_registro = $this->compararRegistro($conex->datos[0],$rude, $nombre_completo, $ci,
                                $genero, $sie,
                                $paralelo, $turno, $unidad_educativa);
                            */
                            $num_errores = 0;
                            $error_registro = "";
                            $tempNombre = $conex->datos[0]->nombre;
                            $tempNombre = preg_replace('/\s+/', ' ', $tempNombre);
                            $nombre_completo = preg_replace('/\s+/', ' ', $nombre_completo);

                            /*********
                             * NOMBRE
                             *********/
                            if($tempNombre == $nombre_completo) {
                                // TODO OK
                            }else{
                                $num_errores = $num_errores + 1;
                                $error_registro = $error_registro . "Nombre: ARCHIVO:" . $nombre_completo . "--<br>";
                                $error_registro = $error_registro . "Nombre: BASE DB:" . $tempNombre  . "--<br>";



                            }

                            /*********
                             * GENERO
                             *********/
                            if($conex->datos[0]->genero == $genero) {
                                // TODO OK
                            }else{
                                $num_errores = $num_errores + 1;
                                $error_registro = $error_registro . "Genero: ARCHIVO:" . $genero . "--<br>";
                                $error_registro = $error_registro . "Genero: BASE DB:" .
                                    $conex->datos[0]->genero  . "--<br>";
                            }

                            /*********
                             * U EDUCATIVA
                             *********/
                            $u_educativa = $conex->datos[0]->u_educativa;
                            $u_educativa = preg_replace('/\s+/', ' ', $u_educativa);
                            $u_educativa = trim($u_educativa);
                            $unidad_educativa = preg_replace('/\s+/', ' ', $unidad_educativa);

                            if($u_educativa == $unidad_educativa) {
                                // TODO OK
                            }else{
                                $num_errores = $num_errores + 1;
                                $error_registro = $error_registro . "u_educativa: ARCHIVO:" . $unidad_educativa . "--<br>";
                                $error_registro = $error_registro . "u_educativa: BASE DB:" .
                                    $u_educativa  . "--<br>";
                            }

                            if($num_errores > 0){
                                $texto = $texto . "<hr>--------- ERROR AL COMPARAR VALORES -------- <br>";
                                $texto = $texto . "ARCHIVO: " . $miArchivoo . "<br>";
                                $texto = $texto . "RUDE: " . $rude . "<br>";
                                $texto = $texto . "REGISTROS EN BDDS: <br>" . $error_registro . "<br>";
                            }




                        }else{
                            $texto = $texto . "<hr>--------- ERROR -------- <br>";
                            $texto = $texto . "ARCHIVO: " . $miArchivoo . "<br>";
                            $texto = $texto . "RUDE: " . $rude . "<br>";
                            $texto = $texto . "REGISTROS EN BDDS: " . $conex->num_filas . "<br>";
                            $texto = $texto . "DATOS<br>";

                            $texto = $texto .
                                $num . ";" .
                                $rude . ";" .
                                $ape_pat . " " . $ape_mat . " " . $nombre . ";" .
                                $ci . ";" .
                                $genero . ";" .
                                $sie . ";" .
                                $paralelo . ";" .
                                $turno . ";" .
                                $unidad_educativa . ";" .
                                "<br>";


                            $temp =
                                "INSERT INTO estudiantes
                                (
                                  rude
                                  ,ci
                                 ,nombre
                                 ,genero
                                 ,sie
                                 ,paralelo
                                 ,turno
                                 ,u_educativa
                                )
                                VALUES
                                (
                                  '$rude'
                                  ,'$ci'
                                 ,'$ape_pat $ape_mat $nombre'
                                 ,'$genero'
                                 ,'$sie'
                                 ,'$paralelo'
                                 ,'$turno'
                                 ,'$unidad_educativa'
                                );" .
                                "<br>";
                            $this->error_sql = $this->error_sql . $temp;
                            $texto = $texto . $temp;

                        }

                        /*
                        $texto = $texto .
                            $num . ";" .
                            $rude . ";" .
                            $ape_pat . " " . $ape_mat . " " . $nombre . ";" .
                            $ci . ";" .
                            $genero . ";" .
                            $sie . ";" .
                            substr($paralelo,10) . ";" .
                            $turno . ";" .
                            substr($unidad_educativa,13) . ";" .
                            "<br>";
                        */
                    }

                }
            }
            return $texto;
        }

        private function compararRegistro(Objeto $datosreg, $rude, $nombre_completo, $ci, $genero, $sie, $paralelo,
                                          $turno, $unidad_educativa)
        {
            $error = "";
            if($datosreg->nombre != $nombre_completo){
                $error = $error . "Nombre: " . $nombre_completo;
            }

            return $error;

        }
    }