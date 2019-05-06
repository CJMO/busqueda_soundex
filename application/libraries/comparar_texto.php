<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comparar_texto {
    
    private $CI;
   
    public function comparar($nombre){
        
        $this->CI =& get_instance();
        
        /* Utiliza '-' como caracteres de tokenización */
        $tok = strtok($nombre, "-");
        
        $resultados = array();
        
        $sql_like = "";

        while ($tok !== false) {

            if(trim($tok) != ""){
                $sql_like = '"%-'.$tok.'%" OR nombre_codificado LIKE "%'.$tok.'-%"' ;
            }
            
            $query = $this->CI->db->query('SELECT * FROM usuario WHERE nombre_codificado LIKE '. $sql_like );
        
            //print $sql_like."<BR>";
            
            /*foreach ($query->result() as $row){
                print "{$row->nombre} <BR>";
            }*/
            
            $resultados[] = $query->result();
                
            $tok = strtok("-");
        }

        //$array_global = array_merge($resultados[0], $resultados[1]);
        
        foreach ($resultados as &$resultado){
            foreach ($resultado as $key => $row){
                $row = (array) $row;
                $resultado[$row['nombre']] = $row;
                unset($resultado[$key]); 
            }
        }
        
        $num_segmentos = count($resultados);
        
        if($num_segmentos == 1){
            return $resultados[0];
            /*foreach ($resultados[0] as $row){
                print "{$row['nombre']} <BR>";
            }*/
        }
        else if($num_segmentos == 2){
            
            $result = $this->array_intersect_key_recursive($resultados[0], $resultados[1]);  
            return $result;
            
            //print_r($result);

            /*foreach ($result as $row){
                print "{$row['nombre']} <BR>";
            }*/
            
            //print count($resultados[0])."-".count($resultados[1])."-".count($result);
        }
        else if($num_segmentos == 3){
            
            $result = $this->array_intersect_key_recursive($resultados[0], $resultados[1]);
            $result = $this->array_intersect_key_recursive($result, $resultados[2]);    

            return $result;
            
            /*foreach ($result as $row){
                print "{$row['nombre']} <BR>";
            }*/
            
            //print count($resultados[0])."-".count($resultados[1])."-".count($result);
        }
        else if($num_segmentos == 4){
            
            $result = $this->array_intersect_key_recursive($resultados[0], $resultados[1]);
            $result = $this->array_intersect_key_recursive($result, $resultados[2]);
            $result = $this->array_intersect_key_recursive($result, $resultados[3]);                
            
            return $result;

            /*foreach ($result as $row){
                print "{$row['nombre']} <BR>";
            }*/
            
            //print count($resultados[0])."-".count($resultados[1])."-".count($result);
        }
        
    }
    
    
    public function comparar_original($nombre){
        
        /* Utiliza '-' como caracteres de tokenización */
        $tok = strtok($nombre, "-");
        
        $sql_like = "";

        while ($tok !== false) {

            if(trim($tok) != ""){
                $sql_like .= '"%-'.$tok.'%" OR nombre_codificado LIKE "%'.$tok.'-%"' ;
            }
            
            $tok = strtok("-");
        }
        
        $this->CI =& get_instance();
        $query = $this->CI->db->query('SELECT * FROM usuario WHERE nombre_codificado LIKE '. $sql_like );
        
        //print $sql_like; return;
        
        //$query = $this->CI->db->query('SELECT * FROM usuario WHERE nombre_codificado LIKE "%-'.$nombre.'%" OR nombre_codificado LIKE "%'.$nombre.'-%"');
        
        return $query->result();
        
        /*foreach ($query->result() as $row){
            print "{$row->nombre} <BR>";
        }*/
        
    }
    
    /** 
    * Recursively computes the intersection of arrays using keys for comparison.
    * 
    * @param   array $array1 The array with master keys to check.
    * @param   array $array2 An array to compare keys against.
    * @return  array associative array containing all the entries of array1 which have keys that are present in array2.
    **/
    public function array_intersect_key_recursive(array $array1, array $array2) {
        $array1 = array_intersect_key($array1, $array2);
        foreach ($array1 as $key => &$value) {
            if (is_array($value) && is_array($array2[$key])) {
                $value = $this->array_intersect_key_recursive($value, $array2[$key]);
            }
        }
        return $array1;
    }
    
}
