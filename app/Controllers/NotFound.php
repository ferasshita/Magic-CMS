<?php 
class NotFound extends CI_Controller 
{
 public function __construct() 
 {
    parent::__construct(); 
 } 

 public function index() 
 { 
    //$this->output->set_status_header('404'); 
    $this->load->view('errors/404');//loading in custom error view
 } 
} 
?>
