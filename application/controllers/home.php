<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	private $_tpl = 'template';
	private $_data;

	function __construct(){
		parent::__construct();

		$this->load->library('user_library');
		$this->load->library('alert_library');

		$this->load->helper('controle_helper');

		if(!$this->user_library->verifica_logado()){
			redirect(base_url().'user/login');
		}

		$this->_data['session_user'] = $this->session->userdata('usuario');
		
		// var_dump($this->session->userdata('usuario'));


		$this->load->model('home_model');

	}

	public function index(){
		$this->_data['view'] 	= 'home';
		$this->_data['titulo']	= 'Dashboard';
		$this->_data['icon'] 	= 'th-large';
		$this->_data['saldo_mensal'] = $this->home_model->soma_controle_mes(date('Y-m'));
		$this->_data['saldo_total'] = $this->home_model->saldo_total();
		$this->_data['gatos_mes'] = $this->home_model->gatos_mes();
		//$this->_data['view'] = 'home';
		$this->load->view($this->_tpl,$this->_data);
	}

	public function grafico1(){
		header('Content-Type: text/html; charset=utf-8');

		$this->load->helper('help_helper');
		$gastos = $this->home_model->gastos();

		$this->load->library('phplot/phplot');

		// SetFileFormat("png");
		$grafico = new PHPLot();


		$grafico->SetTitle("Ultimos Gastos"); 
		$grafico->SetXTitle("Mes"); 
		$grafico->SetYTitle("Valor"); 
		#Definimos os dados do gráfico 

		foreach ($gastos as $key => $value) {
			$dados[$key] = array(mes_ano_ext($value->mes_ano_referente), $value->soma);
			# code...
		}

		$grafico->SetDataValues($dados); 

		$grafico->SetPlotType("bars");
		#Exibimos o gráfico 
		$grafico->DrawGraph();
	}

	public function grafico2(){
		header('Content-Type: text/html; charset=utf-8');

		$this->load->helper('help_helper');
		$sobras = $this->home_model->sobras();

		$this->load->library('phplot/phplot');

		// SetFileFormat("png");
		$grafico = new PHPLot();


		$grafico->SetTitle("Ultimos Saldos"); 
		$grafico->SetXTitle("Mes"); 
		$grafico->SetYTitle("Valor"); 
		#Definimos os dados do gráfico 

		foreach ($sobras as $key => $value) {
			$dados[$key] = array(mes_ano_ext($value->mes_ano_referente), $value->soma);
		}

		$grafico->SetDataValues($dados); 

		$grafico->SetPlotType("bars");
		#Exibimos o gráfico 
		$grafico->DrawGraph();
	}


	public function graph1(){
		$this->load->helper('help_helper');
		$gastos = $this->home_model->sum_gastos_meses();

		foreach ($gastos as $key => $gasto) {
			$referencia = explode('-', $gasto->mes_ano_referente);
			$ano = $referencia[0];
			$mes = mes_ext( $referencia[1] );

			$mes_ano_referencia = $mes . '/' . $ano;

			$meses[] = $mes_ano_referencia; 

			if($gasto->gatos_mes < 0){
				$dados[] = $gasto->gatos_mes*-1;
			}else{
				$dados[] = $gasto->gatos_mes;
			}
		}

		if(count($gastos) == 1){
			$referencia = explode('-', $gastos[0]->mes_ano_referente);
			$ano = $referencia[0];
			$n_mes = $referencia[1] - 1;

			if($n_mes == 0){
				$n_mes == 12;
				$ano = (int) $ano - 1;
			}

			$mes = mes_ext( $n_mes ) ;
			$mes_ano_referencia = $mes . '/' . $ano;

			$meses[count($dados)] = array($mes_ano_referencia);
			$dados[count($dados)] = array(0);
		}

		$json = array(
			'meses' => $meses,
			'dados' => $dados
			);

		echo json_encode($json);
	}

	public function graph2(){
		$this->load->helper('help_helper');
		$saldos = $this->home_model->sum_saldo_meses();

		foreach ($saldos as $key => $saldo) {
			$referencia = explode('-', $saldo->mes_ano_referente);
			$ano = $referencia[0];
			$mes = mes_ext( $referencia[1] );

			$mes_ano_referencia = $mes . '/' . $ano;

			$meses[] = $mes_ano_referencia; 

			if($saldo->gatos_mes < 0){
				$dados[] = $saldo->gatos_mes*1;
			}else{
				$dados[] = $saldo->gatos_mes;
			}
		}

		if(count($saldos) == 1){
			$referencia = explode('-', $saldos[0]->mes_ano_referente);
			$ano = $referencia[0];
			$n_mes = $referencia[1] - 1;

			if($n_mes == 0){
				$n_mes == 12;
				$ano = (int) $ano - 1;
			}

			$mes = mes_ext( $n_mes ) ;
			$mes_ano_referencia = $mes . '/' . $ano;

			$meses[count($dados)] = array($mes_ano_referencia);
			$dados[count($dados)] = array(0);
		}

		$json = array(
			'meses' => $meses,
			'dados' => $dados
			);

		echo json_encode($json);
	}


}

/* End of file home.php */
/* Location: ./application/controllers/home.php */