<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {

	private $_table = 'controle_mensal';
	private $_user;

	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->_user = $this->session->userdata('usuario');
		$this->load->database();
		$this->db->where('id_usuario',$this->_user['id']);
	}


	function gastos(){
		$this->db->select(" sum( (valor * -1) ) as soma, mes_ano_referente ");
		$this->db->where('id_usuario',$this->_user['id']);
		$this->db->where('tipo','debito');
		$this->db->group_by('mes_ano_referente');
		$this->db->order_by('mes_ano_referente','desc');
		$query = $this->db->get('controle_mensal','6');
		return $query->result();
	}

	function sobras(){
		$this->db->select(" sum(valor) as soma, mes_ano_referente ");
		$this->db->where('tipo','credito');
		$this->db->group_by('mes_ano_referente');
		$this->db->order_by('mes_ano_referente','desc');
		$query = $this->db->get('controle_mensal','6');
		return $query->result();
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

	function gatos_mes(){
		$this->db->where('id_usuario',$this->_user['id']);
		$this->db->where('tipo','debito');
		$this->db->where('efetuado','1');
		// $this->db->like('mes_ano_referente',$mes_ano_referente);
		$this->db->like('mes_ano_referente',date('Y-m'));
		$this->db->select("SUM(valor) as gatos_mes");
		$query = $this->db->get($this->_table);
		return $query->row();

		// $this->db->where('id_usuario',$this->_user['id']);
		// $this->db->where('tipo','debito');
		// $this->db->like('mes_ano_referente',date('Y-m'));
		// $this->db->select("SUM(BASE64_DECODE(valor)) as gatos_mes");
		// $query = $this->db->get($this->_table);
		// return $query->row();
	}

	function sum_gastos_meses(){
		$this->db->where('id_usuario',$this->_user['id']);
		$this->db->where('tipo','debito');
		$this->db->where('efetuado','1');
		$this->db->group_by( ' SUBSTR( mes_ano_referente,(1),(7) ) ' );
		$this->db->order_by('mes_ano_referente', 'DESC');
		$this->db->select("SUM(valor) as gatos_mes, SUBSTR( mes_ano_referente,(1),(7) ) as mes_ano_referente ");
		$this->db->limit(6);
		$query = $this->db->get($this->_table);
		return $query->result();
	}

	function sum_saldo_meses(){
		$this->db->where('id_usuario',$this->_user['id']);
		$this->db->where('efetuado','1');
		$this->db->group_by( ' SUBSTR( mes_ano_referente,(1),(7) ) ' );
		$this->db->order_by('mes_ano_referente', 'DESC');
		$this->db->select("SUM(valor) as gatos_mes, SUBSTR( mes_ano_referente,(1),(7) ) as mes_ano_referente ");
		$this->db->limit(6);
		$query = $this->db->get($this->_table);
		return $query->result();
	}
}