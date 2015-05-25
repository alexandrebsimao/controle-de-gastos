<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controle extends CI_Controller {

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

		$this->load->model('controle_model');

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

		$this->_data['view'] = 'controle/index';
		$this->_data['titulo'] = 'Controle Mensal';
		$this->_data['icon'] = 'calendar';

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

		$this->_data['dados'] = $this->controle_model->get_controle_mensal($mes_ano_referente);
		$this->_data['saldo_mensal'] = $this->controle_model->soma_controle_mes($mes_ano_referente);
		$this->_data['saldo_total'] = $this->controle_model->saldo_total();
		$this->_data['gastos_mes'] = $this->controle_model->gastos_mes($mes_ano_referente);
		$this->_data['credito_mes'] = $this->controle_model->credito_mes($mes_ano_referente);

		$this->load->view($this->_tpl,$this->_data);
	}


	public function novo_registro(){

		$this->load->helper('controle_helper');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('codigo','Código','trim|xss_clean');
		$this->form_validation->set_rules('descricao','Descrição','required|trim|xss_clean');
		$this->form_validation->set_rules('valor','Valor','required|trim|xss_clean');
		$this->form_validation->set_rules('observacao','Observação','trim|xss_clean');
		$this->form_validation->set_rules('efetuada','Efetuada','trim|xss_clean');
		// $this->form_validation->set_rules('data','Data','required|trim|xss_clean');
		$this->form_validation->set_rules('mes_ano_referencia','Mês/Ano Referência','required|trim|xss_clean');

		$session_user = $this->session->userdata('usuario');

		if($this->form_validation->run() == TRUE){

			if($this->input->post('tipo') == 'debito'){
				$valor = ($this->input->post('valor') * -1);
			}else{
				$valor = $this->input->post('valor');
			}

			$valor = str_replace(array('.',','), array('','.'), $valor);

			$data = explode('/', $this->input->post('mes_ano_referencia'));

			$dados = array(
				'tipo' 			=> $this->input->post('tipo'),
				'codigo' 		=> $this->input->post('codigo'),
				'descricao' 	=> $this->input->post('descricao'),
				'valor' 		=> $valor,
				'observacao' 	=> $this->input->post('observacao'),
				'efetuado' 		=> $this->input->post('efetuada'),
				'data' 			=> $data[0],
				'mes_ano_referente' => data2bd($this->input->post('mes_ano_referencia')),
				'id_usuario' 	=> $session_user['id'],
				);

			$this->controle_model->novo_controle($dados);

			$this->alert_library->set_alert('Registro cadastrado com sucesso!','success');

			redirect(base_url().'controle/novo_registro');

		}else{	
			$this->_data['codigo'] 		= array('type'=>'text','name'=>'codigo','class'=>'form-control');
			$this->_data['descricao'] 	= array('type'=>'text','name'=>'descricao','class'=>'form-control');
			$this->_data['valor'] 		= array('type'=>'text','name'=>'valor','class'=>'form-control money');
			$this->_data['observacao'] 	= array('name'=>'observacao','class'=>'form-control');
			$this->_data['efetuada']	= array('name'=>'efetuada','name'=>'1');
			$this->_data['data'] 		= array('type'=>'text','name'=>'data','class'=>'form-control date');
			$this->_data['mes_ano_referencia'] = array('type'=>'text','name'=>'mes_ano_referencia','class'=>'form-control date','data-date-format'=>'dd/mm/yyyy');
			$this->_data['salvar'] 		= array('name'=>'salvar','type'=>'submit','value'=>'Cadastrar','class'=>'btn btn-success');

			$mes = array('Mês','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');

			$ano[0] = 'Ano';
			for ($i=2010; $i < 2040; $i++) { 
				$ano[$i] = $i;
			}

			$this->_data['mes'] = $mes;
			$this->_data['ano'] = $ano;

			$this->_data['titulo'] 		= 'Controle Mensal - Novo Registro';
			$this->_data['icon'] 		= 'calendar';

			$this->_data['view'] 		= 'controle/form_registro';

			$this->load->view($this->_tpl,$this->_data);			
		}

	}

	public function editar_registro($id){
		$this->load->helper('controle_helper');

		$this->load->library('form_validation');

		$this->form_validation->set_rules('codigo','Código','trim|xss_clean');
		$this->form_validation->set_rules('descricao','Descrição','required|trim|xss_clean');
		$this->form_validation->set_rules('valor','Valor','required|trim|xss_clean');
		$this->form_validation->set_rules('observacao','Observação','trim|xss_clean');
		$this->form_validation->set_rules('efetuada','Efetuada','trim|xss_clean');
		// $this->form_validation->set_rules('data','Data','required|trim|xss_clean');
		$this->form_validation->set_rules('mes_ano_referencia','Mês/Ano Referência','required|trim|xss_clean');

		$session_user = $this->session->userdata('usuario');

		if($this->form_validation->run() == TRUE){

			if($this->input->post('tipo') == 'debito'){
				$valor = ($this->input->post('valor') * -1);
			}else{
				$valor = $this->input->post('valor');
			}

			$valor = str_replace(array('.',','), array('','.'), $valor);

			$data = explode('/', $this->input->post('mes_ano_referencia'));
			$dados = array(
				'tipo' 			=> $this->input->post('tipo'),
				'codigo' 		=> $this->input->post('codigo'),
				'descricao' 	=> $this->input->post('descricao'),
				'valor' 		=> $valor,
				'observacao' 	=> $this->input->post('observacao'),
				'efetuado' 		=> $this->input->post('efetuada'),
				'data' 			=> $data[0],
				'mes_ano_referente' => data2bd($this->input->post('mes_ano_referencia')),
				'id_usuario' 	=> $session_user['id'],
				);
			// var_dump($dados);exit;
			if($this->controle_model->editar_controle($dados,$id)){
				$this->alert_library->set_alert('Registro atualizado com sucesso!','success');
			}else{
				$this->alert_library->set_alert('Houve um erro ao tentar atualizar registro!','danger');
			}

			redirect(base_url().'controle/editar_registro/'.$id);

		}else{	

			$dados = $this->controle_model->registro_by_id($id);

			$this->_data['dados'] 		= $dados;

			$this->_data['codigo'] 		= array('type'=>'text','name'=>'codigo','class'=>'form-control','value'=>$dados->codigo);
			$this->_data['descricao'] 	= array('type'=>'text','name'=>'descricao','class'=>'form-control','value'=>$dados->descricao);
			$this->_data['valor'] 		= array('type'=>'text','name'=>'valor','class'=>'form-control money','value'=>str_replace('-','',number_format($dados->valor,2,'',',')));
			$this->_data['observacao'] 	= array('name'=>'observacao','class'=>'form-control','value'=>$dados->observacao);
			$this->_data['efetuada']	= array('name'=>'efetuada','name'=>'1');
			$this->_data['data'] 		= array('type'=>'text','name'=>'data','class'=>'form-control date','value'=>$dados->data);
			$this->_data['mes_ano_referencia'] = array('type'=>'text','name'=>'mes_ano_referencia','class'=>'form-control date','value'=>bd2data($dados->mes_ano_referente),'data-date-format'=>'dd/mm/yyyy');
			$this->_data['salvar'] 		= array('name'=>'salvar','type'=>'submit','value'=>'Cadastrar','class'=>'btn btn-success');

			$mes = array('Mês','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');

			$ano[0] = 'Ano';
			for ($i=2010; $i < 2040; $i++) { 
				$ano[$i] = $i;
			}

			$this->_data['mes'] = $mes;
			$this->_data['ano'] = $ano;

			$this->_data['titulo'] 		= 'Controle Mensal - Editar Registro';
			$this->_data['icon'] 		= 'calendar';
			$this->_data['view'] 		= 'controle/form_registro';

			$this->load->view($this->_tpl,$this->_data);			
		}

	}

	public function remover_registro($id){
		if($this->controle_model->remover($id)){
			$this->alert_library->set_alert('Registro removido com sucesso!','success');
		}else{
			$this->alert_library->set_alert('Houve um erro ao tentar remover registro!','danger');
		}

		redirect(base_url().'controle/index/');
	}

	public function registros_fixo($mes_ano_referencia){
		if($this->controle_model->importar_registros_fixo($mes_ano_referencia)){
			$this->alert_library->set_alert('Registros importados com sucesso!','success');
		}else{
			$this->alert_library->set_alert('Os registros já estão atualizados!','warning');
		}

		redirect(base_url().'controle/index/');
	}
}

/* End of file controle.php */
/* Location: ./application/controllers/controle.php */