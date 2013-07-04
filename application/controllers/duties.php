<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Duties extends CI_Controller {
	protected $user_job_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'duties_model' );

		$this->user_job_id = $this->session->userdata( 'job_id' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Duty list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'duties' 
																					,$this->duties_model->getTotalDuties( JOB_ABILITIES, array( 'job_id' => $this->user_job_id ) )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);
		$template_param['attributes'] = $this->duties_model->getAllJobDuties( $offset, PER_PAGE, array( 'job_id' => $this->user_job_id ) );

		# Template meta data
		$template_param['heading']			= 'Job Duties for <i>'.$this->session->userdata( 'job_title' ).'</i>';
		$template_param['table_heading']	= array(
														'Duty Code'
														,'Duty Name'
														,'Duty Description'
														,'Active'
													);
		$template_param['add_link']			= base_url().'duties/new_duties';
		$template_param['delete_url']		= base_url().'duties/delete_duties';
		$template_param['update_url']		= base_url().'duties/update_duties';
		$template_param['add_link_text']	= 'Add Duty';
		$template_param['counter']	= $offset;
		$template_param['key']	= 'duty_id';


		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['attr_selection']	= $this->get_duties_list();
		$template_param['content']			= 'templates/job_attribute_template';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function new_duties() {
		# Check user's session
		$this->template_library->check_session( 'user' );

		if( $this->input->post() )
			$this->save_duty( 'new' );

		$template_param['action'] = 'Add New';
		$template_param['content']= 'duties';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function save_duties() {
		$job_duty = array( 
							'job_id' => $this->user_job_id
							,'active' => 'Yes'
						  );
		$items = $this->input->post( 'item' );
		if( $items ){
			for( $i = 0; $i < count( $items ); $i++ ){
				$duty = array( 'duty_id' => $items[$i] );
				$this->duties_model->saveNewJobDuty( array_merge( $duty, $job_duty ) );
			}
		}
		$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> New duty has been added successfully!', 'class' => 'info' ) );
		redirect( base_url().'duties' );
	}

	public function update_duties() {
		if( $this->input->is_ajax_request() ){

			$items = $this->input->post( 'item' );
			if( $items ){
				for( $i = 0; $i < count( $items ); $i++ ){
					$where = array( 
									'duty_id' => $items[$i]
									,'job_id' => $this->user_job_id
								  );
					$this->duties_model->updateJobDuty( array( 'active' => $this->input->post( 'state' ) ), $where );
				}
			}

			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Duties has been updated successfully!', 'class' => 'info' ) );
			echo base_url().'duties';

		}
	}

	public function get_duties_list() {
		$data['save_url'] = base_url().'duties/save_duties';
		$data['attr_list'] = $this->duties_model->getAllDuties( 0, 1000 );
		return $this->load->view( 'templates/attribute_list_template', $data, true );
	}

	public function delete_duties() {
		if( $this->input->is_ajax_request() ){
			if( is_array( $this->input->post('item') ) ){
				$items = $this->input->post('item');
				for( $s = 0; $s < count( $items ); $s++ ){
					$db_data = array( 
								'duty_id' => $items[ $s ]
								,'job_id' => $this->user_job_id
							);
					$this->duties_model->deleteJobDuty( $db_data );
				}
			}else{
				$db_data = array( 
								'duty_id' => $this->input->post('item')
								,'job_id' => $this->user_job_id
							);
				$this->duties_model->deleteJobDuty( $db_data );
			}
			
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Duty has been deleted successfully!', 'class' => 'info' ) );
			echo base_url().'duties';
		}
	}

}

/* End of file duties.php */
/* Location: ./application/controllers/duties.php */