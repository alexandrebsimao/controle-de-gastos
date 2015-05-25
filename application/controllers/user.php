<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	private $_tpl = 'template';
	private $_data;

	function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->_data['session_user'] = $this->session->userdata('usuario');
		$this->load->library('alert_library');
	}

	public function index(){
		redirect(base_url().'user/login');
	}

	public function login() {
		$this->load->view('user/login',$this->_data);
	}

	public function autenticar() {
		$this->load->helper('user_helper');
		$user 		= $this->input->post('user');
		$pass 		= encrypt_pass($this->input->post('pass'));
		$hash 		= md5(sha1(crypt(rand())));
		$lembrar 	= $this->input->post('lembrar');

		if($usuario = $this->user_model->autenticar($user,$pass,$hash,$lembrar)){
			$session_user = array(
				'usuario' => array(
					'id' 		=> $usuario->id,
					'usuario' 	=> $usuario->usuario,
					'nome' 		=> $usuario->nome,
					'hash' 		=> $hash,
					)
				);

			$this->session->set_userdata($session_user);

			//exit;

			redirect(base_url());

		}else{
			$this->alert_library->set_alert('Login/Senha estão incorretos!','alert-error');

			redirect(base_url().'user/login');
		}

		//var_dump($pass);
	}


	public function usuarios(){
		$this->_data['usuarios'] = $this->user_model->get_all_users();
		$this->_data['view'] = 'user/index';
		$this->_data['titulo'] = 'Usuários';
		$this->_data['icon'] 	= 'user';

		$this->load->view($this->_tpl,$this->_data);

	}

	public function novo_usuario(){
		$this->load->helper('user_helper');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('nome','Nome','required|xss_clean|trim|max_length[150]');
		$this->form_validation->set_rules('email','E-mail','required|xss_clean|trim|max_length[250]');
		$this->form_validation->set_rules('usuario','Usuário','required|xss_clean|trim|max_length[50]');
		$this->form_validation->set_rules('senha','Senha','required|xss_clean|trim|max_length[50]');
		$this->form_validation->set_rules('conf_senha','Confirmação de Senha','required|xss_clean|trim|max_length[50]');

		if($this->form_validation->run() == true){
			$senha 		= $this->input->post('senha');
			$conf_senha = $this->input->post('conf_senha');

			if($senha == $conf_senha){
				$dados = array(
					'nome' 		=> $this->input->post('nome'),
					'email' 	=> $this->input->post('email'),
					'usuario' 	=> $this->input->post('usuario'),
					'senha' 	=> encrypt_pass($this->input->post('senha')),
					'ativado' 	=> 0,
					'lembrar' 	=> 0,
					'ip' 		=> 0,
					'ultimo_acesso'	=> 0,
					'recuperacao_senha'	=> 0,
					'hash'		=> null,
					);

				$this->user_model->novo_usuario($dados);

				$this->alert_library->set_alert('Cadastrado com sucesso!','success');
				redirect(base_url().'user/usuarios');

			}else{
				$this->alert_library->set_alert('As senha não são identicas!','error');

				redirect(base_url().'user/novo_usuario');
			}

		}else{
			$this->load->library('form_validation');

			$this->_data['nome'] 		= array('name'=>'nome','type'=>'text','class'=>'form-control');
			$this->_data['email'] 		= array('name'=>'email','type'=>'text','class'=>'form-control');
			$this->_data['usuario'] 	= array('name'=>'usuario','type'=>'text','class'=>'form-control');
			$this->_data['senha'] 		= array('name'=>'senha','type'=>'password','class'=>'form-control');
			$this->_data['conf_senha'] 	= array('name'=>'conf_senha','type'=>'password','class'=>'form-control');
			$this->_data['salvar'] 		= array('name'=>'salvar','type'=>'submit','value'=>'Cadastrar','class'=>'btn btn-success');
			
			$this->_data['titulo'] 		= 'Usuários - Novo Usuário';
			$this->_data['icon'] 		= 'user';
			$this->_data['view'] 		= 'user/form_user';

			$this->load->view($this->_tpl,$this->_data);			
		}

	}


	public function editar_usuario($id){
		$this->load->helper('user_helper');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email','E-mail','required|xss_clean|trim|max_length[250]');

		if($this->form_validation->run() == true){
			$senha 		= $this->input->post('senha');
			$conf_senha = $this->input->post('conf_senha');

			$dados = array(
				'email' 	=> $this->input->post('email'),
				);

			if($senha != ''){
				if($senha == $conf_senha){
					$dados['senha'] = encrypt_pass($this->input->post('senha'));	
				}else{
					$this->alert_library->set_alert('As senha não são identicas!','error');

					redirect(base_url().'user/novo_usuario/'.$id);
				}	
			}

			$this->user_model->editar_usuario($dados,$id);
			
			$this->alert_library->set_alert('Alterado com sucesso!','success');

			redirect(base_url().'user/usuarios');

		}else{
			$this->load->library('form_validation');

			$dados = $this->user_model->get_usuario($id);

			$this->_data['nome'] 		= array('name'=>'nome','type'=>'text','readonly'=>'readonly','value'=>$dados->nome,'class'=>'form-control');
			$this->_data['email'] 		= array('name'=>'email','type'=>'text','value'=>$dados->email,'class'=>'form-control');
			$this->_data['usuario'] 	= array('name'=>'usuario','type'=>'text','readonly'=>'readonly','value'=>$dados->usuario,'class'=>'form-control');
			$this->_data['senha'] 		= array('name'=>'senha','type'=>'password','class'=>'form-control');
			$this->_data['conf_senha'] 	= array('name'=>'conf_senha','type'=>'password','class'=>'form-control');
			$this->_data['salvar'] 		= array('name'=>'salvar','type'=>'submit','value'=>'Cadastrar','class'=>'btn btn-success');

			$this->_data['titulo'] = 'Usuário - Editar Usuário';
			$this->_data['icon'] 		= 'user';
			$this->_data['view'] = 'user/form_user';

			$this->load->view($this->_tpl,$this->_data);			
		}

	}

	public function status($id){
		$dados = $this->user_model->get_usuario($id);
		if($dados->ativado == 0){
			$update = array('ativado' => 1);
		}else{
			$update = array('ativado' => 0);
		}

		$this->user_model->editar_usuario($update,$id);
		
		$this->alert_library->set_alert('Alterado com sucesso!','success');

		redirect(base_url().'user/usuarios');

	}

	public function logout(){
		$usuario = $this->session->userdata('usuario');

		if($usuario != null){
			$usuario['id'] = $usuario['id'];
			$this->user_model->logout($usuario);


			// $session_user = array(
			// 	'usuario' => null
			// 	);

			$this->session->set_userdata('usuario', null);
		}

		// var_dump($this->session->userdata('usuario'));exit;
		
		redirect(base_url());
	}

}

/* End of file user.php */
/* Location: ./application/controllers/user.php */