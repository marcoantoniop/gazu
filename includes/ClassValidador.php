<?php
    /**
     * Created by PhpStorm.
     * User: MARCOP
     * Date: 25/6/2019
     * Time: 10:02 PM
     */

    class ClassValidador
    {
        public static function devolverSoloNumeros($cadena){
            return $output = preg_replace( '/[^0-9]/', '', $cadena);
        }
        public static function eliminarEspacios($cadena){
            return str_replace(' ','', $cadena);
        }

        public static function eliminarCiExpedido($cadena){
            $cadena = str_replace('Ch.','', $cadena);
            $cadena = str_replace('CH.','', $cadena);
            $cadena = str_replace('CBBA','', $cadena);
            $cadena = str_replace('PT','', $cadena);
            $cadena = str_replace('Stc','', $cadena);
            $cadena = str_replace('DNI','', $cadena);
            $cadena = str_replace('.','', $cadena);
            return $cadena;

        }

        public static function limpiarSie($cadena){
            $cadena = substr($cadena,4);
            $cadena = str_replace(':','', $cadena);
            $cadena = str_replace('8048O3O1','80480301', $cadena);
            return $cadena;
        }

        public static function limpiarTurno($cadena){
            $cadena = substr($cadena,7);
            $cadena = str_replace('_','', $cadena);
            return $cadena;
        }

        public static function limpiarRude($cadena){
            $cadena = ClassValidador::eliminarEspacios($cadena);
            $cadena = str_replace('.','', $cadena);
            return $cadena;
        }

        /**
         * Tipos admitidos
         * 'numero','texto','hora','fecha'
         * @param $tipoDato string
         * @param $dato_bdds string
         * @return string
         */
        public static function limpiarTipoDato($tipoDato,$dato_bdds){
            $cadena = $dato_bdds;
            //echo $dato_bdds;
            switch ($tipoDato){
                case "numero":
                    $cadena = ClassValidador::eliminarEspacios($dato_bdds);
                    $cadena = ClassValidador::devolverSoloNumeros($cadena);
                    break;
                case "texto":
                    //$cadena = preg_match("/^[a-zA-Z0-9]+$/",'', $dato_bdds);
                    //$cadena = preg_replace( '/[^a-zA-Z0-9áéíóúÁÉÍÓÚÑñ ]/', '', $dato_bdds);
                    $cadena = ClassValidador::corregirCaracteresEspeciales($dato_bdds);
                    //$cadena = preg_match("/^[a-zA-Z0-9]+$/",'', $dato_bdds);
                    break;
                case "hora":
                    $cadena = ClassValidador::devolverSoloNumeros($cadena);
                    //$cadena = preg_match("/^[a-zA-Z0-9]+$/", $dato_bdds);
                    break;
                case "fecha":
                    //$cadena = preg_match("/^[a-zA-Z0-9]+$/", $dato_bdds);
                    break;
            }
            return $cadena;
        }

        /**
         * @param $str string
         * @return string|string[]
         */
        public static function corregirCaracteresEspeciales($str)
        {
            $a = array('À', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Î', 'Ï', 'Ð', 'Ò', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Û', 'Ü', 'Ý', 'ß', 'à', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'ê', 'ë', 'ì', 'î', 'ï', 'ñ', 'ò', 'ô', 'õ', 'ö', 'ø', 'ù', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ','г');
            $b = array('A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'D', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'r');
            return str_replace($a, $b, $str);
        }
    }