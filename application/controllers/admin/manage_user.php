<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_user extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model( 'manage_user_model' );
		$this->load->model( 'job_model' );
		$this->load->model( 'department_model' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( );

		# Users list
		$data['pagination'] = $this->template_library->get_pagination(
																		'control_panel/manage_user' 
																		,$this->manage_user_model->getTotalUsers()
																		,PER_PAGE
																	 );
		$data['users_list'] = $this->manage_user_model->getAllUsers( $offset, PER_PAGE );
		$data['counter'] = $offset;
		$template_param['users_list'] = $this->load->view( 'templates/results', $data, true );

		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['content'] = 'admin/manage_user';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function new_user() {
		# Check user's session
		$this->template_library->check_session( );

		if( $this->input->post() ) $this->save_user( 'add' );

		$data['departments'] = $this->department_model->getAllDepartment( 0, 1000 );
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['users_form'] = $this->load->view( 'templates/add_user', $data, true );
		$template_param['content'] = 'admin/add_user';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function update_user( $uid ) {
		# Check user's session
		$this->template_library->check_session( );

		$user_details = $this->manage_user_model->getUserDetails( $uid );
		if( $this->input->post() ) $this->save_user( 'edit' );

		$data['departments'] = $this->department_model->getAllDepartment( 0, 1000 );
		$data['user_detais'] = $user_details[0];
		
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['users_form'] = $this->load->view( 'templates/add_user', $data, true );
		$template_param['content'] = 'admin/add_user';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function save_user( $action ) {
		$avatar = array();
		if( !empty( $_FILES['avatar']['name'] ) ){
			$this->load->library( 'upload_library' );
			$filename = substr(microtime( true ), 0, 10).'_'.mt_rand( 1, 1000000 ).'.jpg';
			$avatar = array( 'avatar' => 'user/'.$filename);

			$upload = $this->upload_library->do_upload( 'user', $filename );
			$up_error = null;
			if( isset( $upload['error'] ) ) {
				$up_error = ' However, ' . trim( $upload['error'] );
			}
		}
		
		if( $action == 'add' ) {
			$new_id = $this->manage_user_model->saveNewUser( array_merge( $this->input->post(), $avatar) );
			
			if( $new_id )
				$this->session->set_flashdata( 'message', array('str' => 'New user has been added successfully!'.$up_error, 'class' => is_null($up_error) ? 'n_ok' : 'n_warning' ) );
			else
				$this->session->set_flashdata( 'message', array('str' => 'Alert: There is some problem with the system, new user cannot be saved!', 'class' => 'n_error' ) );

		} elseif ( $action == 'edit' ) {
			$this->manage_user_model->updateUser( array_merge( $this->input->post(), $avatar) );
			$this->session->set_flashdata( 'message', array( 'str' => 'User has been updated successfully!'.$up_error, 'class' => is_null($up_error) ? 'n_ok' : 'n_warning' ) );
		}
		
		redirect( base_url().'control_panel/manage_user/' );
	}

	public function get_job(){
		if( $this->input->is_ajax_request() ){
			
			echo json_encode( $this->job_model->getAllJob( 0, 1000, $this->input->post( 'dept' ) ) );

		}
	}	

	public function delete_user() {
		if( $this->input->is_ajax_request() ) {
			$this->manage_user_model->deleteUser( $this->input->post() );
			echo "User deleted successfully!";
		}
	}	

	public function email_temp() {		
		$data['from']	= 'E-Performance Administrator';
		$data['to']		= 'Test User';
		$data['msg']	= 'Henry Sy was born to a poor family in Xiamen, China on December 25,1924. He is the son of Henry H. Sy. He graduated from San Beda College Mendiola. He immigrated to the Philippines and got his start by selling rejected and overrun shoes from Tondo.';
		$email_temp = $this->load->view('templates/email_template', $data, true);

		$email_conf = array(
								'to'			=> 'mgarcega.microsourcing@gmail.com'
								,'from_name'	=> $data['from']
								,'from'			=> 'no-reply@eperformance.com'
								,'subj'			=> 'Test Email'
								,'msg'			=> $data['msg']
							);
		$this->template_library->send_email( $email_conf );
	}
}

/* End of file manage_user.php */
/* Location: ./application/controllers/manage_user.php */