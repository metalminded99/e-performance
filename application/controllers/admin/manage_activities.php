<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Activities extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model( 'activities_model' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( );

		# Activities list
		$data['pagination'] = $this->template_library->get_pagination(
																		'control_panel/manage_activities' 
																		,$this->activities_model->getTotalActivities( DUTIES )
																		,'admin'
																		,PER_PAGE
																	 );

		$data['h_title'] = 'Manage Activities';
		$data['listing'] = $this->activities_model->getAllActivities( $offset, PER_PAGE );
		$data['th'] = array(
								'Activity Code'
								,'Activity Name'
								,'Activity Description'
								,'Date Added'
							);
		$data['add_button'] = anchor(
										base_url().'control_panel/manage_activities/new_activity'
										,'Add new activity'
										,'class="button add"'
									);
		$data['counter'] = $offset;
		$data['d_uri'] = 'manage_activities/delete_activity';
		$data['u_uri'] = 'manage_activities/update_activity';
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'templates/results_listing', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function new_activity() {
		# Check user's session
		$this->template_library->check_session( );

		if( $this->input->post() )
			$this->save_activity( 'add' );

		# Activities form
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_activities', '', true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function update_activity( $activity_id = 0 ) {
		# Check user's session
		$this->template_library->check_session( );
		if( !is_integer( $activity_id ) && $activity_id == 0 )
			redirect( base_url().'control_panel/manage_activities' );

		if( $this->input->post() )
			$this->save_activity( 'edit' );

		# Activities form
		$activities = $this->activities_model->getAllActivities( 0, 1, array( 'activity_id' => $activity_id ) );
		$data['activities'] = $activities[0];
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_activities', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function save_activity( $action ) {
		if( $action == 'add' ) {
			$this->activities_model->saveNewActivity( $this->input->post() );
			$this->session->set_flashdata( 'message', array('str' => 'New activity has been added successfully!', 'class' => 'n_ok' ) );
		}elseif( $action == 'edit' ) {
			$this->activities_model->updateActivity( $this->input->post() );
			$this->session->set_flashdata( 'message', array('str' => 'Activity has been updated successfully!', 'class' => 'n_ok' ) );
		}

		redirect( base_url().'control_panel/manage_activities' );
	}

	public function delete_activity() {
		if( $this->input->is_ajax_request() ) {
			$this->activities_model->deleteActivity( array( 'activity_id' => $this->input->post( 'id' ) ) );
			echo "Activity deleted successfully!";
		}
	}

}

/* End of file manage_activities.php */
/* Location: ./application/controllers/manage_activities.php */