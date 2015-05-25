<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controle_fixo extends CI_Controller {

	private $_tpl = 'template';
	private $_data;

	function __construct(){
		parent::__construct();

		$this->load->library('user_library');

		if(!$this->user_library->verifica_logado()){
			redirect(base_url().'user/login');
		}

		$this->_data['session_user'] = $this->session->userdata('usuario');
		
		// var_dump($this->session->userdata('usuario'));

		$this->load->library('alert_library');

		$this->load->model('controle_fixo_model');
	}

	public function index(){
		$this->load->helper('controle_helper');

		if( isset($_POST) && !empty($_POST) ){
			$mes = $this->input->post('mes');
			$ano = $this->input->post('ano');

			$filtro = array(
				'mes' => $mes,
				'ano' => $ano,
				);

			$this->session->set_userdata(array('filtro'=>$filtro));

		}

		$this->load->library('form_validation');

		$this->_data['view'] 	= 'controle_fixo/index';
		$this->_data['titulo'] 	= 'Controle Fixo';
		$this->_data['icon'] 	= 'list-alt';

		$session_filtro = $this->session->userdata('filtro');

		if($session_filtro != false){
			$mes = $session_filtro['mes'];

			if(strlen($mes) == 1){
				$mes = '0'.$mes;
			}

			$ano = $session_filtro['ano'];
			$mes_ano_referente = $ano.'-'.$mes;
		}else{
			$mes_ano_referente = date('Y-m');
		}

		//var_dump($mes_ano_referente);exit;

		$this->_data['data_referente'] = explode('-', $mes_ano_referente);

		$mes = array();
		$ano = array();

		$mes = array('Mês','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');

		$ano[0] = 'Ano';
		for ($i=2010; $i < date('Y')+10; $i++) { 
			$ano[$i] = $i;
		}

		$this->_data['mes'] = $mes;
		$this->_data['ano'] = $ano;

		$this->_data['dados'] = $this->controle_fixo_model->get_controle_mensal();
		$this->_data['saldo_fixo'] = $this->controle_fixo_model->soma_controle_mes();
		$this->_data['gasto_fixo'] = $this->controle_fixo_model->gasto_total();
		$this->_data['soma_credito'] = $this->controle_fixo_model->soma_credito_mes();

		$this->load->view($this->_tpl,$this->_data);
	}


	public function novo_registro(){

		$this->load->library('form_validation');

		$this->form_validation->set_rules('codigo','Código','trim|xss_clean');
		$this->form_validation->set_rules('descricao','Descrição','required|trim|xss_clean');
		$this->form_validation->set_rules('valor','Valor','required|trim|xss_clean');
		$this->form_validation->set_rules('observacao','Observação','trim|xss_clean');
		$this->form_validation->set_rules('efetuada','Efetuada','trim|xss_clean');
		$this->form_validation->set_rules('data','Data','required|trim|xss_clean');

		$session_user = $this->session->userdata('usuario');

		if($this->form_validation->run() == TRUE){

			if($this->input->post('tipo') == 'debito'){
				$valor = ($this->input->post('valor') * -1);
			}else{
				$valor = $this->input->post('valor');
			}

			$valor = str_replace(array('.',','), array('','.'), $valor);

			$dados = array(
				'tipo' 			=> $this->input->post('tipo'),
				'codigo' 		=> $this->input->post('codigo'),
				'descricao' 	=> $this->input->post('descricao'),
				'valor' 		=> $valor,
				'observacao' 	=> $this->input->post('observacao'),
				'data' 			=> $this->input->post('data'),
				'id_usuario' 	=> $session_user['id'],
				);

			$this->controle_fixo_model->novo_controle($dados);

			$this->alert_library->set_alert('Registro cadastrado com sucesso!','success');

			redirect(base_url().'controle_fixo/novo_registro');

		}else{	
			$this->_data['codigo'] 		= array('type'=>'text','name'=>'codigo','class'=>'form-control');
			$this->_data['descricao'] 	= array('type'=>'text','name'=>'descricao','class'=>'form-control');
			// $this->_data['valor'] 		= array('type'=>'text','name'=>'valor','class'=>'form-control');
			$this->_data['valor'] 		= array('type'=>'text','name'=>'valor','class'=>'form-control money');
			$this->_data['observacao'] 	= array('name'=>'observacao','class'=>'form-control');
			$this->_data['data'] 		= array('type'=>'text','name'=>'data','class'=>'form-control');
			$this->_data['salvar'] 		= array('name'=>'salvar','type'=>'submit','value'=>'Cadastrar','class'=>'btn btn-success');

			$mes = array('Mês','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');

			$ano[0] = 'Ano';
			for ($i=2010; $i < 2040; $i++) { 
				$ano[$i] = $i;
			}

			$this->_data['mes'] = $mes;
			$this->_data['ano'] = $ano;

			$this->_data['titulo'] 		= 'Controle Fixo - Novo Registro';
			$this->_data['icon'] 		= 'list-alt';
			$this->_data['view'] 		= 'controle_fixo/form_registro';

			$this->load->view($this->_tpl,$this->_data);			
		}

	}

	public function editar_registro($id){

		$this->load->library('form_validation');

		$this->form_validation->set_rules('codigo','Código','trim|xss_clean');
		$this->form_validation->set_rules('descricao','Descrição','required|trim|xss_clean');
		$this->form_validation->set_rules('valor','Valor','required|trim|xss_clean');
		$this->form_validation->set_rules('observacao','Observação','trim|xss_clean');
		$this->form_validation->set_rules('data','Data','required|trim|xss_clean');

		$session_user = $this->session->userdata('usuario');

		if($this->form_validation->run() == TRUE){

			if($this->input->post('tipo') == 'debito'){
				$valor = ($this->input->post('valor') * -1);
			}else{
				$valor = $this->input->post('valor');
			}

			$valor = str_replace(array('.',','), array('','.'), $valor);

			$dados = array(
				'tipo' 			=> $this->input->post('tipo'),
				'codigo' 		=> $this->input->post('codigo'),
				'descricao' 	=> $this->input->post('descricao'),
				'valor' 		=> $valor,
				'observacao' 	=> $this->input->post('observacao'),
				'data' 			=> $this->input->post('data'),
				'id_usuario' 	=> $session_user['id'],
				);
			// var_dump($dados);exit;
			if($this->controle_fixo_model->editar_controle($dados,$id)){
				$this->alert_library->set_alert('Registro atualizado com sucesso!','success');
			}else{
				$this->alert_library->set_alert('Houve um erro ao tentar atualizar registro!','danger');
			}

			redirect(base_url().'controle_fixo/editar_registro/'.$id);

		}else{	

			$dados = $this->controle_fixo_model->registro_by_id($id);

			$this->_data['dados'] 		= $dados;

			$this->_data['codigo'] 		= array('type'=>'text','name'=>'codigo','class'=>'form-control','value'=>$dados->codigo);
			$this->_data['descricao'] 	= array('type'=>'text','name'=>'descricao','class'=>'form-control','value'=>$dados->descricao);
			$this->_data['valor'] 		= array('type'=>'text','name'=>'valor','class'=>'form-control money','value'=>str_replace('-','',number_format($dados->valor,2,'',',')));
			$this->_data['observacao'] 	= array('name'=>'observacao','class'=>'form-control','value'=>$dados->observacao);
			$this->_data['efetuada']	= array('name'=>'efetuada','name'=>'1');
			$this->_data['data'] 		= array('type'=>'text','name'=>'data','class'=>'form-control','value'=>$dados->data);
			$this->_data['salvar'] 		= array('name'=>'salvar','type'=>'submit','value'=>'Cadastrar','class'=>'btn btn-success');

			$mes = array('Mês','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');

			$ano[0] = 'Ano';
			for ($i=2010; $i < 2040; $i++) { 
				$ano[$i] = $i;
			}

			$this->_data['mes'] = $mes;
			$this->_data['ano'] = $ano;

			$this->_data['titulo'] 		= 'Controle Fixo - Editar Registro';
			$this->_data['icon'] 		= 'list-alt';
			$this->_data['view'] 		= 'controle_fixo/form_registro';

			$this->load->view($this->_tpl,$this->_data);			
		}

	}

	public function remover_registro($id){
		if($this->controle_fixo_model->remover($id)){
			$this->alert_library->set_alert('Registro removido com sucesso!','success');
		}else{
			$this->alert_library->set_alert('Houve um erro ao tentar remover registro!','danger');
		}

		redirect(base_url().'controle_fixo/index/');
	}
}

/* End of file controle.php */
/* Location: ./application/controllers/controle.php */