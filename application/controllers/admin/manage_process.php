<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_process extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model( 'process_model' );
		$this->load->model( 'job_model' );
		$this->load->model( 'department_model' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( );

		# Process list
		$data['pagination'] = $this->template_library->get_pagination(
																		'control_panel/manage_process' 
																		,$this->process_model->getTotalProcess()
																		,PER_PAGE
																	 );

		$data['h_title'] = 'Manage Process';
		$data['listing'] = $this->process_model->getAllProcess( $offset, PER_PAGE );
		$data['th'] = array(
								'Process Title'
								,'Description'
								,'Start Date'
								,'End Date'
							);
		$data['add_button'] = anchor(
										base_url().'control_panel/manage_process/add'
										,'Add new process'
										,'class="button add"'
									);
		$data['counter'] = $offset;
		$data['d_uri'] = 'manage_process/delete';
		$data['u_uri'] = 'manage_process/update';
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'templates/results_listing', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function add() {
		# Check user's session
		$this->template_library->check_session( );

		if( $this->input->post() ) $this->save_process( 'add' );

		$this->load->model( 'manage_user_model' );

		# Process form
		$data['users_list'] = $this->manage_user_model->getAllUsers( 0, 1000 );
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_process', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function update( $proc_id = 0 ) {
		# Check user's session
		$this->template_library->check_session( );

		if( !is_integer( $proc_id ) && $proc_id <= 0 )
			redirect( base_url().'control_panel/manage_process' );

		if( $this->input->post() ) $this->save_process( 'edit', $proc_id );

		$this->load->model( 'manage_user_model' );
		# Job form
		$process_details	= $this->process_model->getAllProcess( 0, 1, array( 'proc_id' => $proc_id ) );
		$data['process']	= $process_details[0];
		$data['users_list'] = $this->manage_user_model->getAllUsers( 0, 1000 );
		$data['emp_process'] = $this->process_model->getEmpProcess( $proc_id );

		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_process', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function save_process( $action, $proc_id = 0 ) {
		if( $action == 'add' ) {
			$this->process_model->saveNewProcess( $this->input->post() );
			$this->session->set_flashdata( 'message', array( 'str' => 'New process has been added successfully!', 'class' => 'n_ok' ) );
		}elseif( $action == 'edit' ) {
			$this->process_model->updateProcess( $proc_id, $this->input->post() );
			$this->session->set_flashdata( 'message', array( 'str' => 'Process has been updated successfully!', 'class' => 'n_ok' ) );
		}

		redirect( base_url().'control_panel/manage_process' );
	}

	public function delete() {
		if( $this->input->is_ajax_request() ) {
			$this->process_model->deleteProcess( array( 'proc_id' => $this->input->post( 'id' ) ) );
			echo "Process deleted successfully!";
		}
	}
}

/* End of file manage_process.php */
/* Location: ./application/controllers/manage_process.php */