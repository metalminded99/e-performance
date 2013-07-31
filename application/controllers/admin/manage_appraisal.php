<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_appraisal extends CI_Controller {
	protected $user_job_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'appraisal_model' );
	}

	public function index( $offset = 0 ) {
		# Check admin's session
		$this->template_library->check_session( 'admin' );

		# Appraisal list
		$data['pagination'] = $this->template_library->get_pagination(
																		'control_panel/manage_appraisal' 
																		,$this->appraisal_model->getTotalAppraisal()
																		,PER_PAGE
																	 );

		$data['appraisal'] = $this->appraisal_model->getAllAppraisal( $offset, PER_PAGE );

		$data['counter'] = $offset;
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'templates/appraisal_list_template', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function add() {
		# Check user's session
		$this->template_library->check_session( );

		if( $this->input->post() ) $this->save_appraisal( 'add' );

		$this->load->model( 'manage_user_model' );

		# Appraisal form
		$data['users_list'] = $this->manage_user_model->getAllUsers( 0, 1000 );
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_appraisal', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function update( $appraisal_id = 0 ) {
		# Check user's session
		$this->template_library->check_session( );

		if( !is_integer( $appraisal_id ) && $appraisal_id <= 0 )
			redirect( base_url().'control_panel/manage_appraisal' );

		if( $this->input->post() ) $this->save_appraisal( 'edit', $appraisal_id );

		$this->load->model( 'manage_user_model' );
		# Job form
		$appraisal_details	= $this->appraisal_model->getAllAppraisal( 0, 1, array( 'appraisal_id' => $appraisal_id ) );
		$data['appraisal']	= $appraisal_details[0];
		$data['users_list'] = $this->manage_user_model->getAllUsers( 0, 1000 );
		$data['emp_appraisal'] = $this->appraisal_model->getEmpAppraisal( $appraisal_id );

		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_appraisal', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function save_appraisal( $action, $appraisal_id = 0 ) {
		if( $action == 'add' ) {
			$this->appraisal_model->saveNewAppraisal( $this->input->post() );
			$this->session->set_flashdata( 'message', array( 'str' => 'New appraisal has been added successfully!', 'class' => 'n_ok' ) );
		}elseif( $action == 'edit' ) {
			$this->appraisal_model->updateAppraisal( $appraisal_id, $this->input->post() );
			$this->session->set_flashdata( 'message', array( 'str' => 'Appraisal has been updated successfully!', 'class' => 'n_ok' ) );
		}

		redirect( base_url().'control_panel/manage_appraisal' );
	}

	public function delete() {
		if( $this->input->is_ajax_request() ) {
			$this->appraisal_model->deleteAppraisal( array( 'appraisal_id' => $this->input->post( 'id' ) ) );
			echo "Appraisal deleted successfully!";
		}
	}
}

/* End of file appraisal.php */
/* Location: ./application/controllers/appraisal.php */