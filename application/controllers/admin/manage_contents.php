<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_contents extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model( 'contents_model' );
	}

	public function news( $offset = 0 ) {
		# Check user's sesssion
		$this->template_library->check_session( );

		# News list
		$data['pagination'] = $this->template_library->get_pagination(
																		'control_panel/Manage_contents/news' 
																		,$this->contents_model->getTotalNews()
																		,PER_PAGE
																	 );

		$data['h_title'] = 'Manage News Contents';
		$data['listing'] = $this->contents_model->getAllNews( $offset, PER_PAGE );
		$data['th'] = array(
								'News Title'
								,'Contents'
								,'Active'
								,'Date Posted'
							);
		$data['add_button'] = anchor(
										base_url().'control_panel/manage_contents/new_news'
										,'Add new news'
										,'class="button add"'
									);
		$data['counter'] = $offset;
		$data['d_uri'] = 'manage_contents/delete_news';
		$data['u_uri'] = 'manage_contents/update_news';
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'templates/results_listing', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function new_news() {
		# Check user's session
		$this->template_library->check_session( );

		if( $this->input->post() ) $this->save_news( 'add' );

		# News form
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_news', '', true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}
	
	public function save_news( $action ) {
		if( $action == 'add' ) {
			$this->contents_model->saveNewNews( $this->input->post() );
			$this->session->set_flashdata( 'message', array( 'str' => 'New news has been added successfully!', 'class' => 'n_ok' ) );
		}elseif( $action == 'edit' ) {
			$this->contents_model->updateNews( $this->input->post() );
			$this->session->set_flashdata( 'message', array( 'str' => 'News has been updated successfully!', 'class' => 'n_ok' ) );
		}

		redirect( base_url().'control_panel/manage_contents/news' );
	}

	public function update_news( $news_id = 0 ) {
		# Check user's session
		$this->template_library->check_session( );

		if( !is_integer( $news_id ) && $news_id <= 0 )
			redirect( base_url().'control_panel/manage_news' );

		if( $this->input->post() )
			$this->save_news( 'edit' );

		# news form
		$news_details = $this->contents_model->getAllnews( 0, 1, null, array( 'news_id' => $news_id ) );
		$data['news'] = $news_details[0];
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_news', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function delete_news() {
		if( $this->input->is_ajax_request() ) {
			$this->contents_model->deleteNews( array( 'news_id' => $this->input->post( 'id' ) ) );
			echo "News deleted successfully!";
		}
	}

}

/* End of file news.php */
/* Location: ./application/controllers/news.php */