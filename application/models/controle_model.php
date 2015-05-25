<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controle_model extends CI_Model {

	private $_table = 'controle_mensal';
	private $_user;

	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->_user = $this->session->userdata('usuario');
		$this->load->database();
		$this->db->where('id_usuario',$this->_user['id']);
	}


	function get_controle_mensal($mes_ano_referente){
		$this->db->like('mes_ano_referente',$mes_ano_referente);
		$query = $this->db->get($this->_table);
		return $query->result();
	}

	function novo_controle($dados){
		$this->db->insert($this->_table,$dados);
        return $this->db->affected_rows();
	}

	function soma_controle_mes($mes_ano_referente){
		$this->db->where('id_usuario',$this->_user['id']);
		$this->db->select("SUM(valor) as total_mes");
		$this->db->where('efetuado',1);
		$this->db->like('mes_ano_referente',$mes_ano_referente);
		$query = $this->db->get($this->_table);
		return $query->row();
	}

	function saldo_total(){
		$this->db->where('id_usuario',$this->_user['id']);
		$this->db->select("SUM(valor) as saldo_total");
		$this->db->where('efetuado',1);
		$query = $this->db->get($this->_table);
		return $query->row();
	}

	function credito_mes($mes_ano_referente){
		$this->db->where('id_usuario',$this->_user['id']);
		$this->db->select("SUM(valor) as total_mes");
		$this->db->where('tipo','credito');
		$this->db->like('mes_ano_referente',$mes_ano_referente);
		$query = $this->db->get($this->_table);
		return $query->row();
	}

	function gastos_mes($mes_ano_referente){
		$this->db->where('id_usuario',$this->_user['id']);
		$this->db->where('tipo','debito');
		$this->db->where('efetuado','1');
		$this->db->like('mes_ano_referente',$mes_ano_referente);
		// $this->db->like('mes_ano_referente',date('Y-m'));
		$this->db->select("SUM(valor) as gastos_mes");
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

	function importar_registros_fixo($mes_ano_referencia){
		$this->db->select('codigo, tipo, descricao, valor, observacao, data, id_usuario');
		$c_fixo = $this->db->get('controle_fixo')->result();

		foreach ($c_fixo as $key => $value) {
			$this->db->like('mes_ano_referente',$mes_ano_referencia);
			$this->db->where('codigo',$value->codigo);
			$this->db->where('descricao',$value->descricao);
			$c_mensal = $this->db->get('controle_mensal')->num_rows();

			if($c_mensal == 0){
				$value->efetuado = 1;
				$value->mes_ano_referente = $mes_ano_referencia.'-01';
				$this->db->insert($this->_table,$value);
			}else{
				$value->efetuado = 1;
				$value->mes_ano_referente = $mes_ano_referencia.'-01';

				$this->db->where('codigo',$value->codigo);
				$this->db->where('descricao',$value->descricao);
				$this->db->update($this->_table,$value);
			}
		}

		return $this->db->affected_rows();
	}

}