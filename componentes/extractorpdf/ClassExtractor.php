<?php
    /**
     * Created by PhpStorm.
     * User: MARCOP
     * Date: 14/6/2019
     * Time: 05:43 AM
     */

    class ClassExtractor
    {
        public $carpeta;
        public $respuesta;
        public $leercarpeta;
        public $resultadoCarpetas;
        public $resultadoArchivos;
        private $idActual;


        function listar_carpetas() {
            //le añadimos la barra a la carpeta que le hemos pasado
            $ruta = $this->carpeta . "/";
            $contador = 0;
            //pasamos a minúsculas (opcional)
            $ruta = strtolower($ruta) ;

            //comprueba si la ruta que le hemos pasado es un directorio
            if(is_dir($ruta)) {
                //fijamos la ruta del directorio que se va a abrir
                if($dir = opendir($ruta)) {
                    //si el directorio se puede abrir
                    while(($archivo = readdir($dir)) !== false) {
                        //le avisamos que no lea el "." y los dos ".."
                        if($archivo != '.' && $archivo != '..') {
                            //comprobramos que se trata de un directorio
                            if (is_dir($ruta.$archivo)) {
                                //si efectivamente es una carpeta saltará a nuestra próxima función
                                //echo $ruta.$archivo . "<hr>";
                                $this->resultadoCarpetas[$contador] = $archivo;
                                //$this->resultadoCarpetas[$contador] = $ruta.$archivo;
                                $this->idActual = $contador;
                                $this->leercarpeta = $ruta.$archivo;
                                $this->leer_carpeta($archivo, $contador, $ruta.$archivo);
                                $contador = $contador +1;

                            }
                        }
                    }
                    //cerramos directorio abierto anteriormente
                    closedir($dir);
                }
            }
        }

        //recogemos  la ruta para entrar en el segundo nivel
        function leer_carpeta($carpeta, $id, $ruta) {
            //le añadimos la barra final
            //$leercarpeta = $this->leercarpeta . "/";
            $localArray[0] = ["id" => 0, "icono" => "ico", "archivo" => "", "tipò_archivo" => "txt", "carpeta" => $carpeta];
            $leercarpeta = $ruta . "/";
            $contador = 0;
            if(is_dir($leercarpeta)){
                if($dir = opendir($leercarpeta)){
                    while(($archivo = readdir($dir)) !== false){
                        if($archivo != '.' && $archivo != '..') {
                            // Verificamos que el archivo sea pdf
                            if($this->verificarExtensionPdf($archivo)){
                                /* imprimimos el nombre del archivo, si quisieramos podriamos poner en este punto por ejemplo un enlace
                            al archivo para que se abriera una imagen o un PDF al hacer click encima del nombre. */
                                $localArray[$contador] = [
                                    "icono" => "../icons/pdf.png",
                                    "ruta" => $carpeta . "/" . $archivo,
                                    "archivo" => $archivo,
                                    "tipo_archivo" => "pdf",
                                    "carpeta" => $carpeta,
                                    "id"=>$id
                                ];
                                //$this->resultadoArchivos[$contador] = $archivo;
                                $contador = $contador +1;
                                //echo $archivo . "<br>";
                            }
                        }
                    }
                    closedir($dir);
                }
            }
            $this->resultadoArchivos[$id] = $localArray;

        }
        function crearXmlArchivos(){
            $cadenaXML = "";
            $contador = 0;
            $cadenaXML = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rows>\n";
            foreach ($this->resultadoArchivos as $archivo_grupo){
                foreach ($archivo_grupo as $archivo){
                    $cadenaXML = $cadenaXML .
                    "<row id=\"$contador\">
                        <cell>" . $archivo['icono'] . "</cell>
                        <cell>" . $archivo['ruta'] . "</cell>
                        <cell>" . $archivo['archivo'] . "</cell>
                        <cell>" . $archivo['tipo_archivo'] . "</cell>
                        <cell>" . $archivo['carpeta'] . "</cell>
                        <cell>c" . $archivo['id'] . "</cell>
                       </row>\n";
                    //print_r($archivo);
                    $contador = $contador +1;
                }
                //$cadenaXML = $cadenaXML .  "<item id=\"$id\" text=\"$carpeta\" im0=\"folderClosed.gif\"></item>" .
                // "\n";

                //echo '<hr>';
            }
            $cadenaXML = $cadenaXML . "</rows>";

            /*
            * 1.- Creamos la variable que contiene el archivo que tenemos que crear.
            * 2.- preguntamos si existe el archivo, si el archivo existe "se ha modificado"
            en caso contrario el archivo se ha creado.
            * 3.- Con fopen abrimos un archivo o url, en este caso vamos a abrir un archivo
            pasando como parámetro la variable $nombre_archivo que es la que contiene
            nuestro archivo y como segundo parámetro como lo vamos a abrir, en este caso "a"
            que nos abre el fichero en solo lectura y sitúa el puntero al final del fichero
            y en el caso de que no exista lo crea.

            ******Para terminar*******

            4.-Con el fwrite escribimos dentro del archivo la fecha con la hora de Creación
            o modificación, según el caso, con la variable $mensaje,
            */

            $nombre_archivo = "bloques/extractor/archivos.xml";

            unlink($nombre_archivo);
            if(file_exists($nombre_archivo))
            {
                $mensaje = "El Archivo $nombre_archivo se ha modificado";

            }

            else
            {
                $mensaje = "El Archivo $nombre_archivo se ha creado";
            }

            if($archivo = fopen($nombre_archivo, "a"))
            {
                if(fwrite($archivo, $cadenaXML))
                {
                    // echo "Se ha ejecutado correctamente";
                }
                else
                {
                    // echo "Ha habido un problema al crear el archivo";
                }

                fclose($archivo);
            }
        }

        /**
         * METODO QUE SE ENCARGA DE CREAR EL ARCHIVO DE DATOS XML PARA PUEDA SER LLAMADO DESDE DHTMLX
         */
        function crearXmlCarpetas(){
            $cadenaXML = "";
            $cadenaXML = "<tree id=\"0\">\n";
            foreach ($this->resultadoCarpetas as $id => $carpeta){
                $cadenaXML = $cadenaXML .  "<item id=\"c$id\" text=\"$carpeta\" im0=\"folderClosed.gif\"></item>" . "\n";
            }
            $cadenaXML = $cadenaXML . "</tree>";

            /*
            * 1.- Creamos la variable que contiene el archivo que tenemos que crear.
            * 2.- preguntamos si existe el archivo, si el archivo existe "se ha modificado"
            en caso contrario el archivo se ha creado.
            * 3.- Con fopen abrimos un archivo o url, en este caso vamos a abrir un archivo
            pasando como parámetro la variable $nombre_archivo que es la que contiene
            nuestro archivo y como segundo parámetro como lo vamos a abrir, en este caso "a"
            que nos abre el fichero en solo lectura y sitúa el puntero al final del fichero
            y en el caso de que no exista lo crea.

            ******Para terminar*******

            4.-Con el fwrite escribimos dentro del archivo la fecha con la hora de Creación
            o modificación, según el caso, con la variable $mensaje,
            */

            $nombre_archivo = "bloques/extractor/carpetas.xml";

            unlink($nombre_archivo);
            if(file_exists($nombre_archivo))
            {
                $mensaje = "El Archivo $nombre_archivo se ha modificado";

            }

            else
            {
                $mensaje = "El Archivo $nombre_archivo se ha creado";
            }

            if($archivo = fopen($nombre_archivo, "a"))
            {
                if(fwrite($archivo, $cadenaXML))
                {
                    // echo "Se ha ejecutado correctamente";
                }
                else
                {
                    // echo "Ha habido un problema al crear el archivo";
                }

                fclose($archivo);
            }

        }

        private function verificarExtensionPdf($archivo){
            $extension = substr($archivo,-4);
            if($extension == ".pdf"){
                return true;
            }else{
                return false;
            }
        }



    }