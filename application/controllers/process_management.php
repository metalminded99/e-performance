<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Process_management extends CI_Controller {
	protected $user_id;
	protected $dept_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'process_model' );

		$this->user_id = $this->session->userdata( 'user_id' );
		$this->dept_id = $this->session->userdata( 'department_id' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Process list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'process_management' 
																					,$this->process_model->getTotalProcess()
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);
		
		$template_param['process'] = $this->process_model->getAllDeptProcess( 
																				$offset
																				,PER_PAGE
																			);

		# Template meta data
		$template_param['heading']			= $this->session->userdata( 'job_title' ).' Processs';
		$template_param['table_heading']	= array(
														'Process Title'
														,'Description'
														,'Active'
													);
		$template_param['add_link']			= base_url().'process_management/add';
		$template_param['delete_url']		= base_url().'process_management/delete';
		$template_param['update_url']		= base_url().'process_management/update';
		$template_param['add_link_text']	= 'Add Process';
		$template_param['counter']			= $offset;
		$template_param['key']				= 'user_id';
		$template_param['heading']			= 'Process Management';
		$template_param['add_link_text']	= 'Add New Process';

		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'process_management';
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
			$this->save_process( 'add' );

		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['action']		= 'Add New Process';
		$template_param['content']		= 'add_goal';

		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function save_process( $action ) {
		if( $action == 'add' ){
			$department = array( 'department_id' => $this->dept_id );
			$this->process_model->saveNewDeptProcess( array_merge( $department, $this->input->post() ) );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> New goal has been added successfully!', 'class' => 'info' ) );
			redirect( base_url().'process_management' );

		} elseif( $action == 'update' ) {
			$this->process_model->updateDeptProcess( $this->goal_id, $this->input->post() );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Your goal has been updated successfully!', 'class' => 'info' ) );
			redirect( base_url().'process_management' );
		}
	}

	public function update( $goal_id ) {
		# Check user's session
		$this->template_library->check_session( 'user' );
		$this->goal_id = $goal_id;

		if( $this->input->post() )
			$this->save_process( 'update' );

		$where = array(
						'goal_id' => $goal_id
					  );
		$goal = $this->process_model->getAllDeptProcess( 
													0
													,1
													,$where
													,'*'
												);
		if( !count( $goal ) ) redirect( base_url().'process_management' );

		$template_param['process'] = $goal[0];
		// echo "<pre>";
		// print_r($template_param);
		// exit();
		$template_param['left_side_nav'] = $this->load->view( '_components/left_side_nav', '', true );
		$template_param['action']		 = 'Update Process';
		$template_param['content']		 = 'add_goal';

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
			$db_data = array( 'goal_id' => $this->input->post( 'goal_id' ) );
			$this->process_model->deleteDeptProcess( $db_data );
			
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Your goal has been deleted successfully!', 'class' => 'info' ) );
			echo base_url().'process_management';
		}
	}

}

/* End of file process.php */
/* Location: ./application/controllers/process.php */