<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controle_fixo_model extends CI_Model {

	private $_table = 'controle_fixo';
	private $_user;

	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->_user = $this->session->userdata('usuario');
		$this->load->database();
		$this->db->where('id_usuario',$this->_user['id']);
	}


	function get_controle_mensal(){
		$this->db->where('id_usuario',$this->_user['id']);
		$query = $this->db->get($this->_table);
		return $query->result();
	}

	function novo_controle($dados){
		$this->db->insert($this->_table,$dados);
        return $this->db->affected_rows();
	}

	function soma_controle_mes(){
		$this->db->where('id_usuario',$this->_user['id']);
		$this->db->select("SUM(valor) as total_mes");
		$query = $this->db->get($this->_table);
		return $query->row();
	}

	function soma_credito_mes(){
		$this->db->where('id_usuario',$this->_user['id']);
		$this->db->where('tipo','credito');
		$this->db->select("SUM(valor) as total_mes");
		$query = $this->db->get($this->_table);
		return $query->row();
	}

	function saldo_total(){
		$this->db->where('id_usuario',$this->_user['id']);
		$this->db->select("SUM(valor) as saldo_total");
		$query = $this->db->get($this->_table);
		return $query->row();
	}

	function gasto_total(){
		$this->db->where('id_usuario',$this->_user['id']);
		$this->db->where('tipo','debito');
		$this->db->select("SUM(valor) as total_mes");
		$query = $this->db->get($this->_table);
		return $query->row();
	}

	function editar_controle($dados,$id){
		$this->db->where('id',$id);
		$this->db->update($this->_table,$dados);
        return $this->db->affected_rows();
	}

	function registro_by_id($id){
		$this->db->where('id',$id);
		$query = $this->db->get($this->_table);
		return $query->row();
	}

	function remover($id){
		$this->db->where('id',$id);
		$this->db->delete($this->_table);
        return $this->db->affected_rows();
	}

}