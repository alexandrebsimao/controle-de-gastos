<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Alert_library {

    private $ci;
   
    
    public function __construct() {
        $this->ci = &get_instance();
        $this->ci->load->library('session');

    }

    public function alert(){
    	$alert = $this->ci->session->flashdata('alert');
        if($alert['message'] != ''){
            $return_alert = '<div class="alert alert-'.$alert['type'].' alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            '.$alert['message'].'
                        </div>';
        }else{
            $return_alert = '';
        }

        return $return_alert;
    	
    }

    public function set_alert($message,$type){
        $this->ci->session->set_flashdata('alert',array('message'=>$message,'type'=>$type));
    }

}