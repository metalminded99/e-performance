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
		$template_param['attributes'] = $this->appraisal_model->getAllJobAppraisal( $offset, PER_PAGE, array( 'job_id' => $this->user_job_id ) );

		# Template meta data
		$template_param['heading']			= 'Job Appraisal for <i>'.$this->session->userdata( 'job_title' ).'</i>';
		$template_param['table_heading']	= array(
														'Activity Code'
														,'Activity Name'
														,'Activity Description'
														,'Active'
													);
		$template_param['add_link']			= base_url().'appraisal/new_appraisal';
		$template_param['delete_url']		= base_url().'appraisal/delete_appraisal';
		$template_param['update_url']		= base_url().'appraisal/update_appraisal';
		$template_param['add_link_text']	= 'Add Activity';
		$template_param['counter']	= $offset;
		$template_param['key']	= 'activity_id';


		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['attr_selection']	= $this->get_appraisal_list();
		$template_param['content']			= 'templates/job_attribute_template';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function new_appraisal() {
		# Check user's session
		$this->template_library->check_session( 'user' );

		if( $this->input->post() )
			$this->save_activity( 'new' );

		$template_param['action'] = 'Add New';
		$template_param['content']= 'appraisal';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function save_appraisal() {
		$job_activity = array( 
							'job_id' => $this->user_job_id
							,'active' => 'Yes'
						  );
		$items = $this->input->post( 'item' );
		if( $items ){
			for( $i = 0; $i < count( $items ); $i++ ){
				$activity = array( 'activity_id' => $items[$i] );
				$this->appraisal_model->saveNewJobActivity( array_merge( $activity, $job_activity ) );
			}
		}
		$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> New activity has been added successfully!', 'class' => 'info' ) );
		redirect( base_url().'appraisal' );
	}

	public function update_appraisal() {
		if( $this->input->is_ajax_request() ){

			$items = $this->input->post( 'item' );
			if( $items ){
				for( $i = 0; $i < count( $items ); $i++ ){
					$where = array( 
									'activity_id' => $items[$i]
									,'job_id' => $this->user_job_id
								  );
					$this->appraisal_model->updateJobActivity( array( 'active' => $this->input->post( 'state' ) ), $where );
				}
			}

			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Appraisal has been updated successfully!', 'class' => 'info' ) );
			echo base_url().'appraisal';

		}
	}

	public function get_appraisal_list() {
		$data['save_url'] = base_url().'appraisal/save_appraisal';
		$data['attr_list'] = $this->appraisal_model->getAllAppraisal( 0, 1000 );
		return $this->load->view( 'templates/attribute_list_template', $data, true );
	}

	public function delete_appraisal() {
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