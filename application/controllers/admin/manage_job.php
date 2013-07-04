<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_job extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model( 'job_model' );
		$this->load->model( 'department_model' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( );

		# Department list
		$data['pagination'] = $this->template_library->get_pagination(
																		'control_panel/manage_job' 
																		,$this->job_model->getTotalJob()
																		,PER_PAGE
																	 );

		$data['h_title'] = 'Manage Departments';
		$data['listing'] = $this->job_model->getAllJob( $offset, PER_PAGE );
		$data['th'] = array(
								'Job Name'
								,'Description'
								,'Department'
							);
		$data['add_button'] = anchor(
										base_url().'control_panel/manage_job/new_job'
										,'Add new job'
										,'class="button add"'
									);
		$data['counter'] = $offset;
		$data['d_uri'] = 'manage_job/delete_job';
		$data['u_uri'] = 'manage_job/update_job';
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'templates/results_listing', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function new_job() {
		# Check user's session
		$this->template_library->check_session( );

		if( $this->input->post() ) $this->save_job( 'add' );

		# Department form
		$data['departments'] = $this->department_model->getAllDepartment( 0, 1000 );
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_job', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function update_job( $job_id = 0 ) {
		# Check user's session
		$this->template_library->check_session( );

		if( !is_integer( $job_id ) && $job_id <= 0 )
			redirect( base_url().'control_panel/manage_job' );

		if( $this->input->post() )
			$this->save_job( 'edit' );

		# Job form
		$job_details = $this->job_model->getAllJob( 0, 1, null, array( 'job_id' => $job_id ) );
		$data['job'] = $job_details[0];
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_job', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function save_job( $action ) {
		if( $action == 'add' ) {
			$this->job_model->saveNewJob( $this->input->post() );
			$this->session->set_flashdata( 'message', array( 'str' => 'New job has been added successfully!', 'class' => 'n_ok' ) );
		}elseif( $action == 'edit' ) {
			$this->job_model->updateJob( $this->input->post() );
			$this->session->set_flashdata( 'message', array( 'str' => 'Job has been updated successfully!', 'class' => 'n_ok' ) );
		}

		redirect( base_url().'control_panel/manage_job' );
	}

	public function delete_job() {
		if( $this->input->is_ajax_request() ) {
			$this->job_model->deleteJob( array( 'job_id' => $this->input->post( 'id' ) ) );
			echo "Job deleted successfully!";
		}
	}
}

/* End of file manage_user.php */
/* Location: ./application/controllers/manage_user.php */