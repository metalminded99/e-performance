<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_department extends CI_Controller {

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
																		'control_panel/manage_department' 
																		,$this->department_model->getTotalDepartment()
																		,PER_PAGE
																	 );

		$data['h_title'] = 'Manage Departments';
		$data['listing'] = $this->department_model->getAllDepartment( $offset, PER_PAGE );
		$data['th'] = array(
								'Department Name'
								,'Description'
								,'Date Added'
							);
		$data['add_button'] = anchor(
										base_url().'control_panel/manage_department/new_department'
										,'Add new department'
										,'class="button add"'
									);
		$data['counter'] = $offset;
		$data['d_uri'] = 'manage_department/delete_department';
		$data['u_uri'] = 'manage_department/update_department';
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'templates/results_listing', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function new_department() {
		# Check user's session
		$this->template_library->check_session( );

		if( $this->input->post() )
			$this->save_department( 'add' );

		# Department form
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_department', '', true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function update_department( $dept_id = 0 ) {
		# Check user's session
		$this->template_library->check_session( );
		if( !is_integer( $dept_id ) && $dept_id == 0 )
			redirect( base_url().'control_panel/manage_department' );

		if( $this->input->post() )
			$this->save_department( 'edit' );

		# Department form
		$dept_details = $this->department_model->getAllDepartment( 0, 1, array( 'dept_id' => $dept_id ) );
		$data['dept'] = $dept_details[0];
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_department', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function save_department( $action ) {
		if( $action == 'add' ) {
			$this->department_model->saveNewDepartment( $this->input->post() );
			$this->session->set_flashdata( 'message', array('str' => 'New department has been added successfully!', 'class' => 'n_ok' ) );
		}elseif( $action == 'edit' ) {
			$this->department_model->updateDepartment( $this->input->post() );
			$this->session->set_flashdata( 'message', array('str' => 'Department has been updated successfully!', 'class' => 'n_ok' ) );
		}

		redirect( base_url().'control_panel/manage_department' );
	}

	public function delete_department() {
		if( $this->input->is_ajax_request() ) {
			$this->department_model->deleteDepartment( array( 'dept_id' => $this->input->post( 'id' ) ) );
			echo "Department deleted successfully!";
		}
	}
	
}

/* End of file manage_user.php */
/* Location: ./application/controllers/manage_user.php */