<?php
    /**
     * Created by PhpStorm.
     * User: MARCOP
     * Date: 24/6/2019
     * Time: 02:58 AM
     */

    include_once ('componentes/PdfToText/PdfToText.php');

    class ClassExtractorArchivo
    {
        public $carpeta;
        public $archivo;
        public $texto;
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
             $pdf = new PdfToText();

             $pdf->Separator = "----";
             $pdf->BlockSeparator = ";;;;";
             $miArchivoo = "adjuntos/" . $this->carpeta . "/" . $this->archivo;
             $pdf->Load($miArchivoo);
             $miCadena = $pdf->Text;
             $this->texto = $miCadena;
             $miCadenaArreglo = explode(";;;;",$miCadena);
             $lim = sizeof($miCadenaArreglo);
             $this->arreglo = $miCadenaArreglo;
             $this->lim = $lim;
             /*
             $resultado = "";
             for($i = 0; $i < $lim; $i++){
                 $resultado = $resultado . $i . " --> " . $miCadenaArreglo[$i] . "<br>";
             }
             */

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
    }