<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Duties extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model( 'duties_model' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( );

		# Duties list
		$data['pagination'] = $this->template_library->get_pagination(
																		'control_panel/manage_duties' 
																		,$this->duties_model->getTotalDuties( DUTIES )
																		,'admin'
																		,PER_PAGE
																	 );

		$data['h_title'] = 'Manage Duties';
		$data['listing'] = $this->duties_model->getAllDuties( $offset, PER_PAGE );
		$data['th'] = array(
								'Duty Code'
								,'Duty Name'
								,'Duty Description'
								,'Date Added'
							);
		$data['add_button'] = anchor(
										base_url().'control_panel/manage_duties/new_duty'
										,'Add new duty'
										,'class="button add"'
									);
		$data['counter'] = $offset;
		$data['d_uri'] = 'manage_duties/delete_duty';
		$data['u_uri'] = 'manage_duties/update_duty';
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'templates/results_listing', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function new_duty() {
		# Check user's session
		$this->template_library->check_session( );

		if( $this->input->post() )
			$this->save_duty( 'add' );

		# Duties form
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_duties', '', true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function update_duty( $duty_id = 0 ) {
		# Check user's session
		$this->template_library->check_session( );
		if( !is_integer( $duty_id ) && $duty_id == 0 )
			redirect( base_url().'control_panel/manage_duties' );

		if( $this->input->post() )
			$this->save_duty( 'edit' );

		# Duties form
		$duties = $this->duties_model->getAllDuties( 0, 1, array( 'duty_id' => $duty_id ) );
		$data['duties'] = $duties[0];
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_duties', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function save_duty( $action ) {
		if( $action == 'add' ) {
			$this->duties_model->saveNewDuty( $this->input->post() );
			$this->session->set_flashdata( 'message', array('str' => 'New duty has been added successfully!', 'class' => 'n_ok' ) );
		}elseif( $action == 'edit' ) {
			$this->duties_model->updateDuty( $this->input->post() );
			$this->session->set_flashdata( 'message', array('str' => 'Duty has been updated successfully!', 'class' => 'n_ok' ) );
		}

		redirect( base_url().'control_panel/manage_duties' );
	}

	public function delete_duty() {
		if( $this->input->is_ajax_request() ) {
			$this->duties_model->deleteDuty( array( 'duty_id' => $this->input->post( 'id' ) ) );
			echo "Duty deleted successfully!";
		}
	}

}

/* End of file manage_duties.php */
/* Location: ./application/controllers/manage_duties.php */