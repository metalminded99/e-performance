<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	protected $usr_cmp;

	public function __construct() {
		parent::__construct();		
		$this->load->model( 'login_model' );
	}

	public function index() {
		if( $this->session->userdata( 'user' ) ) 
			redirect( base_url(). 'home' );

		if( $this->input->post() ){
			$this->check_login();
		}else{
			$this->template_library->clear_cache();
			$template_param['content'] = 'user_login';
			$this->template_library->render( 
												$template_param 
												,'user_header'
												,'user_top'
												,'user_footer'
												,'' 
											);
		}
	}

	public function check_login() {
		$login = $this->login_model->verify( $this->input->post( ), 'user' );
		if( count($login) ) {
			# Login success
			if( $login[0]['lvl'] > 1 )
				$this->session->set_userdata( 'user', 1 );
			elseif( $login[0]['lvl'] == '1' )
				$this->session->set_userdata( 'control_panel', 1 );

			foreach ($login as $user_data) {
				$this->session->set_userdata( $user_data );
			}

			$this->login_model->stamp_last_login( array( 'user_id' => $this->session->userdata('user_id') ) );

			if( $this->session->userdata('lvl') == '1' )  {
				redirect( base_url().'control_panel/dashboard' );
			}else{
				redirect( base_url().'home' );
			}

		}else{
			# Login failed
			$this->session->set_flashdata( 'message', '<strong>Login failed!</strong> Username/password does not match.' );
			redirect( base_url() );
		}
	}

	public function logout() {		
		$this->session->sess_destroy();
		redirect( base_url() );

	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */