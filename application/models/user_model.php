<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	private $_table = 'usuario';

	function __construct(){
		parent::__construct();

		$this->load->database();
	}


	public function autenticar($usuario, $senha, $hash,$lembrar = 0){
		$this->db->where('usuario',$usuario);
		$this->db->where('senha',$senha);

		$dados['hash'] = $hash;

		if($lembrar != 0){
			$dados['lembrar'] = $lembrar;
		}

		$this->db->update($this->_table,$dados);

		$this->db->where('ativado','1');
		$this->db->where('hash',$hash);
		$this->db->where('usuario',$usuario);
		$this->db->where('senha',$senha);
		$query = $this->db->get($this->_table);
		//print_r($this->db->last_query());exit;
		// var_dump($query->row());exit;
		return $query->row();
	}

	public function novo_usuario($dados){
		$this->db->insert($this->_table, $dados);
        return $this->db->affected_rows();
	}

	public function editar_usuario($dados,$id){
		$this->db->where('id',$id);
		$this->db->update($this->_table, $dados);
        return $this->db->affected_rows();
	}

	public function verifica_logado($dados){
		$this->db->select('count(*) as logado');
		$this->db->where($dados);
		$query = $this->db->get($this->_table);
		return $query->row()->logado;
	}

	public function logout($dados){
		$this->db->where($dados);
		$this->db->update($this->_table,array('hash'=>null));
        return $this->db->affected_rows();
	}

	public function get_usuario($id){
		$this->db->select('nome, email, usuario, ativado');
		$this->db->where('id',$id);
		$query = $this->db->get($this->_table);
		return $query->row();
	}

	public function get_all_users(){
		$this->db->select('id, nome, usuario, ip, ultimo_acesso, ativado, email');
		$query = $this->db->get($this->_table);
		return $query->result();
	}

}