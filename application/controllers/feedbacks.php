<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedbacks extends CI_Controller {
	protected $user_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'appraisal_model' );

		$this->user_id = $this->session->userdata( 'user_id' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Journal list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'feedbacks' 
																					,$this->appraisal_model->getSelfFeedbackCount( $this->user_id )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);

		$template_param['feedbacks'] = $this->appraisal_model->getSelfFeedback( $offset, PER_PAGE, array( 'user_id' => $this->user_id ) );

		# Template meta data
		$template_param['heading']	= 'My Feedbacks';
		$data['active'] = 'self';
		$template_param['app_menu'] = $this->load->view( '_components/app_menu', $data, true );
		$template_param['counter']	= $offset;

		$template_param['left_side_nav'] = $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']		 = 'self_feedbacks';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function new_journal() {
		# Check user's session
		$this->template_library->check_session( 'user' );

		if( $this->input->post() )
			$this->save_journal( 'new' );

		$template_param['action']			= 'Add New Journal';
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'add_journal';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function save_journal( $action, $journal_id = null ) {
		$user = array( 'user_id' => $this->user_id );
		if( $action == 'new' ){
			$this->appraisal_model->saveNewJournal( array_merge( $user, $this->input->post() ) );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> New journal has been added successfully!', 'class' => 'info' ) );
		}elseif ( $action == 'update' ) {
			$this->appraisal_model->updateJournal( $this->input->post(), $journal_id );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Journal has been added successfully!', 'class' => 'info' ) );
		}

		redirect( base_url().'feedbacks' );
	}

	public function update_journal( $journal_id ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		if( $this->input->post() )
			$this->save_journal( 'update', $journal_id );

		$db_param = array( 
							'journal_id' => $journal_id
							,'user_id' => $this->user_id
						);
		$feedbacks = $this->appraisal_model->getAllFeedbacks( 0, 1, $db_param );
		$template_param['feedbacks']			= $feedbacks[0];
		$template_param['action']			= 'Update Journal';
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'add_journal';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function get_feedbacks_list() {
		$data['save_url'] = base_url().'feedbacks/save_feedbacks';
		$data['attr_list'] = $this->appraisal_model->getAllfeedbacks( 0, 1000, array( 'user_id' => $this->user_id ) );
		return $this->load->view( 'templates/attribute_list_template', $data, true );
	}

	public function delete_feedbacks() {
		if( $this->input->is_ajax_request() ){
			if( is_array( $this->input->post('item') ) ){
				$items = $this->input->post('item');
				for( $s = 0; $s < count( $items ); $s++ ){
					$db_data = array( 
								'Journal_id' => $items[ $s ]
								,'job_id' => $this->user_job_id
							);
					$this->appraisal_model->deleteJobJournal( $db_data );
				}
			}else{
				$db_data = array( 
								'Journal_id' => $this->input->post('item')
								,'job_id' => $this->user_job_id
							);
				$this->appraisal_model->deleteJobJournal( $db_data );
			}
			
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Journal has been deleted successfully!', 'class' => 'info' ) );
			echo base_url().'feedbacks';
		}
	}

}

/* End of file feedbacks.php */
/* Location: ./application/controllers/feedbacks.php */