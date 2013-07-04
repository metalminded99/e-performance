<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model( 'login_model' );
		$this->template_library->clear_cache();
	}

	public function index() {
		if( $this->session->userdata( 'control_panel' ) ) 
			redirect( base_url(). 'control_panel/dashboard' );

		if( $this->input->post() )
			$this->check_login();
		else{
			$data['invalid'] = $this->session->flashdata('invalid') ? true : '';
			$this->load->view('admin/login.php', $data);
		}
	}

	public function check_login() {
		$login = $this->login_model->verify( $this->input->post( ) );
		if( count($login) ) {

			# Login success
			$this->session->set_userdata( 'control_panel', 1 );
			foreach ($login as $user_data) {
				$this->session->set_userdata( $user_data );
			}

			$this->login_model->stamp_last_login( array( 'user_id' => $this->session->userdata('user_id') ) );

			if( $this->session->userdata('lvl') === '1' )  {
				redirect( base_url().'control_panel/dashboard' );
			}

		}else{
			# Login failed
			$this->session->set_flashdata( 'invalid', true );
			redirect( base_url().'admin/login' );
		}
	}

	public function logout() {

		$this->session->sess_destroy();
		redirect( base_url().'admin/login' );

	}

	public function home() {
		# Check user's session
		$this->template_library->check_session( );

		$this->load->model( 'manage_user_model' );
		$this->load->model( 'department_model' );
		$this->load->model( 'job_model' );

		# Dashboard templates
		$users			= $this->manage_user_model->getUsersStats();
		$active_users	= $this->manage_user_model->getUsersActiveStats();
		for( $i=0; $i < count( $users ); $i++ ) {
			$users[$i]['active'] = 0;
			if( isset( $active_users[$i] ) ) {
				if( $active_users[$i]['lvl'] == $users[$i]['lvl'] ) {
					$users[$i]['active'] = $active_users[$i]['active'];
				}
			}
		}

		$data['users'] = $users;
		$data['department'] = $this->department_model->getDeptStats();
		$data['jobs'] 		= $this->job_model->getJobStats();
		$template_param['sidebar']		= $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content']	= $this->load->view( 'admin/dashboard', $data, true );
		$template_param['content']		= 'templates/admin_template';
		$this->template_library->render( $template_param );
	}
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */