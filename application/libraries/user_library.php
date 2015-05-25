<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_library {

    private $ci;
   
    
    public function __construct() {
        $this->ci = &get_instance();
        $this->ci->load->library('session');

    }

    public function verifica_logado(){
    	$session_user = $this->ci->session->userdata('usuario');
        $session_user['id'] = $session_user['id'];
        // var_dump($session_user);exit;

    	if($session_user != null){
    		$this->ci->load->model('user_model');
	    	$return = $this->ci->user_model->verifica_logado($session_user);

            // var_dump($this->ci->db->last_query());exit;

	    	if($return == 1){
	    		return true;
	    	}else{
	    		return false;
	    	}
    	}else{
    		return false;
    	}
    	
    }

}