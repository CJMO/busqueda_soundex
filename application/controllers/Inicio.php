<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {
    
    // Página principal
    public function index(){        
        $this->load->view('inicio_vista');
    }
	
    // Opción para buscar nombres
	public function buscar(){
           
        $this->load->library('conversion_texto');
        $this->load->library('comparar_texto');
        
        //$nombre = "Cristian José Muñoz Oliveros";
        $nombre = $this->input->post('nombre');
        $nivel_coincidencia = $this->input->post('nivel_coinc');
        
        $texto = $this->conversion_texto->convertir($nombre);
        //print $nombre. " : ". $texto."-".$nivel_coincidencia."<BR>";
        
        //$datos = $this->comparar_texto->comparar_original($texto); 
        

        // Búsqueda avazada
        if($nivel_coincidencia == 2){
            
            $datos = $this->comparar_texto->comparar($texto);   
            
            // Convertir nuevamente formato Array hacia Object, para desplegrar en vista
            $valor = 0;
            foreach ($datos as $key => $row){
                $datos[$valor] = $row;
                unset($datos[$key]); 
                foreach ($datos as &$d){
                    $d= (object) $d;
                }
            }            
        }
        // búsqueda simple
        else{
            $datos = $this->comparar_texto->comparar_original($texto); 
        }
        
//print_r($datos);        
        
        $data['nombres'] = $datos;
        $data['nombre_busqueda'] = $nombre;

        $this->load->view('detalles_vista', $data);        
        
    }
}