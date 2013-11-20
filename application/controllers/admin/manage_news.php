<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_News extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model( 'news_model' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( );

		# News list
		$data['pagination'] = $this->template_library->get_pagination(
																		'control_panel/manage_news' 
																		,$this->news_model->getTotalNews( DUTIES )
																		,'admin'
																		,PER_PAGE
																	 );

		$data['h_title'] = 'Manage News';
		$data['listing'] = $this->news_model->getAllNews( $offset, PER_PAGE, array( 'active' => 1 ) );
		$data['th'] = array(
								,'News Title'
								,'Content'
								,'Status'
								,'Date Added'
							);
		$data['add_button'] = anchor(
										base_url().'control_panel/manage_news/new_duty'
										,'Add new duty'
										,'class="button add"'
									);
		$data['counter'] = $offset;
		$data['d_uri'] = 'manage_news/delete_duty';
		$data['u_uri'] = 'manage_news/update_duty';
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

		# News form
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_news', '', true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function update_duty( $duty_id = 0 ) {
		# Check user's session
		$this->template_library->check_session( );
		if( !is_integer( $duty_id ) && $duty_id == 0 )
			redirect( base_url().'control_panel/manage_news' );

		if( $this->input->post() )
			$this->save_duty( 'edit' );

		# News form
		$duties = $this->news_model->getAllNews( 0, 1, array( 'duty_id' => $duty_id ) );
		$data['duties'] = $duties[0];
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_news', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function save_duty( $action ) {
		if( $action == 'add' ) {
			$this->news_model->saveNewDuty( $this->input->post() );
			$this->session->set_flashdata( 'message', array('str' => 'New duty has been added successfully!', 'class' => 'n_ok' ) );
		}elseif( $action == 'edit' ) {
			$this->news_model->updateDuty( $this->input->post() );
			$this->session->set_flashdata( 'message', array('str' => 'Duty has been updated successfully!', 'class' => 'n_ok' ) );
		}

		redirect( base_url().'control_panel/manage_news' );
	}

	public function delete_duty() {
		if( $this->input->is_ajax_request() ) {
			$this->news_model->deleteDuty( array( 'duty_id' => $this->input->post( 'id' ) ) );
			echo "Duty deleted successfully!";
		}
	}

}

/* End of file manage_news.php */
/* Location: ./application/controllers/manage_news.php */