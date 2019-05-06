<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conversion_texto {
    
    private $CI;
    
    private $tabla_codificacion = array(
        0 => "P",
        1 => array("B", "V"),
        2 => array("F", "H"),
        3 => array("T", "D"),        
        4 => array("S", "Z","C","X"),
        5 => array("Y", "LL", "L"),
        6 => array("N", "Ñ", "M"),
        7 => array("Q", "K"),
        8 => array("G", "J"),
        9 => array("R", "RR")
    ); 
    
    // Retorna índices en vector donde se encuentra valor buscado, o 'false' si no existe
    public function array_search_recursive( $caracter, $tabla_equivalencias, $strict=false, $path=array() ){
        if( !is_array($tabla_equivalencias) ) {
            return false;
        }

        foreach( $tabla_equivalencias as $clave => $val ) {
            if( is_array($val) &&$subPath = $this->array_search_recursive($caracter, $val, $strict, $path) ) {
                $path = array_merge($path, array($clave), $subPath);
                return $path;
            } elseif( (!$strict && $val == $caracter) || ($strict && $val === $caracter) ) {
                $path[] = $clave;
                return $path;
            }
        }
        
        return false;
    }
    
    /* Variante de función 'str_split' para codificación UTF-8, ya que genera problemas con acentos */
    public function mb_str_split($string, $split_length = 1){
        if ($split_length == 1) {
            return preg_split("//u", $string, -1, PREG_SPLIT_NO_EMPTY);
        } elseif ($split_length > 1) {
            $return_value = [];
            $string_length = mb_strlen($string, "UTF-8");
            for ($i = 0; $i < $string_length; $i += $split_length) {
                $return_value[] = mb_substr($string, $i, $split_length, "UTF-8");
            }
            return $return_value;
        } else {
            return false;
        }
    }
        
    public function hallar_codigo($texto)
    {
        $array = $this->mb_str_split($texto);
        $resultado = "";
        
        foreach ($array as $char) {
            
            // Al buscar tabla de codificación, tratamos indistintamente mayúsculas y minúsuclas            
            $buscar = $this->array_search_recursive( mb_strtoupper($char) , $this->tabla_codificacion);
            if(!$buscar) $resultado = $resultado ."" ; //print "No Existe";
            else $resultado = $resultado. $buscar[0] ; //print_r ($buscar);
         
        }
        //print $resultado."<BR>";
        return $resultado;
    }
    
    public function convertir($texto){
        
        /* Utiliza espacio como caracteres de tokenización */
        $tok = strtok($texto, " ");

        $resultado = "";

        while ($tok !== false) {      
            
            $resultado .= $this->hallar_codigo($tok);
            $resultado .= "-";            
            
            $tok = strtok(" ");
        }
        // se retira último caracter '-' del texto
        $resultado = mb_substr($resultado, 0, -1);
        
        return $resultado;
    }
    
    // Hallar codificación de nombre y guardar en BD, usado en carga inicial de datos
    public function convertir_guardar_BD($texto){
        
        /* Utiliza espacio como caracteres de tokenización */
        $tok = strtok($texto, " ");
        
        $resultado = "";

        while ($tok !== false) {      
            
            $resultado .= $this->hallar_codigo($tok);
            $resultado .= "-";            
            
            $tok = strtok(" ");
        }
        
        // se retira último caracter '-' del texto
        $resultado = mb_substr($resultado, 0, -1);
        
        $this->CI =& get_instance();
        $query = $this->CI->db->query('UPDATE usuario set nombre_codificado = "'.$resultado.'" WHERE nombre = "'.$texto.'"');
    }
}