<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appraisal extends CI_Controller {
	protected $user_job_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'appraisal_model' );

		$this->user_job_id = $this->session->userdata( 'job_id' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Activity list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'appraisal' 
																					,$this->appraisal_model->getTotalAppraisal( array( 'job_id' => $this->user_job_id ) )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
								 												);
		$template_param['appraisals'] = $this->appraisal_model->getAllAppraisal( $offset, PER_PAGE, array( 'job_id' => $this->user_job_id ) );

		# Template meta data
		$template_param['counter']	= $offset;
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'templates/appraisal_template';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function add() {
		# Check user's session
		$this->template_library->check_session( 'user' );

		if( $this->input->post() )
			$this->save_appraisal( 'add' );

		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['action'] = 'Add New Appraisal';
		$template_param['content']= 'add_appraisal';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function save_appraisal( $action, $app_id = 0 ) {
		if( $action == 'add' ) {
			$this->appraisal_model->saveNewAppraisal( $this->input->post() );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> New appraisal has been added successfully!', 'class' => 'info' ) );
		}elseif( $action == 'edit' ) {
			$this->appraisal_model->updateAppraisal( $app_id, $this->input->post() );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Appraisal has been updated successfully!', 'class' => 'info' ) );
		}

		redirect( base_url().'appraisal' );
	}

	public function update( $app_id ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		if( $this->input->post() )
			$this->save_appraisal( 'edit', $app_id );

		$template_param['appraisal'] = $this->appraisal_model->getAllAppraisal( 0, 1, array( 'appraisal_id' => $app_id ) );
		$cat = array(
						'core'
						,'perf'
						,'skills'
						,'abl'
					);
		for ($i=0; $i < count($cat); $i++) { 
			$template_param[ $cat[$i] ] = $this->appraisal_model->getAppraisalQuestion( $app_id, $cat[$i] );
		}

		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['action'] = 'Update Appraisal';
		$template_param['content']= 'add_appraisal';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function delete() {
		if( $this->input->is_ajax_request() ){
			if( is_array( $this->input->post('item') ) ){
				$items = $this->input->post('item');
				for( $s = 0; $s < count( $items ); $s++ ){
					$db_data = array( 
								'activity_id' => $items[ $s ]
								,'job_id' => $this->user_job_id
							);
					$this->appraisal_model->deleteJobActivity( $db_data );
				}
			}else{
				$db_data = array( 
								'activity_id' => $this->input->post('item')
								,'job_id' => $this->user_job_id
							);
				$this->appraisal_model->deleteJobActivity( $db_data );
			}
			
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Activity has been deleted successfully!', 'class' => 'info' ) );
			echo base_url().'appraisal';
		}
	}

}

/* End of file appraisal.php */
/* Location: ./application/controllers/appraisal.php */