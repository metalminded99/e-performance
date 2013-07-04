<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_goal extends CI_Controller {
	protected $user_id;
	protected $user_job_id;
	protected $goal_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'goal_model' );

		$this->user_id		= $this->session->userdata( 'user_id' );
		$this->user_job_id	= $this->session->userdata( 'job_id' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Goal list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'my_goals' 
																					,$this->goal_model->getTotalEmpGoal( $this->user_id )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);
		$where = array( 
						'user_id' => $this->user_id
					  );
		$template_param['goals'] = $this->goal_model->getAllEmpGoal( 
																		$offset
																		,PER_PAGE
																		,$where
																	);

		# Template meta data
		$template_param['heading']			= $this->session->userdata( 'job_title' ).' Goals';
		$template_param['table_heading']	= array(
														'Goal Title'
														,'Description'
														,'Active'
													);
		$template_param['add_link']			= base_url().'my_goal/add';
		$template_param['delete_url']		= base_url().'my_goal/delete';
		$template_param['update_url']		= base_url().'my_goal/update';
		$template_param['add_link_text']	= 'Add Goal';
		$template_param['counter']			= $offset;
		$template_param['key']				= 'user_id';
		$template_param['heading']			= 'My Goals';
		$template_param['add_link_text']	= 'Add New Goal';

		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'employee_goals';
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
			$this->save_goals( 'add' );

		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['action']		= 'Add New Goal';
		$template_param['content']		= 'add_goal';

		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function save_goals( $action ) {
		if( $action == 'add' ){

			$user = array( 'user_id' => $this->user_id );
			$this->goal_model->saveNewEmpGoal( array_merge( $user, $this->input->post() ) );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> New goal has been added successfully!', 'class' => 'info' ) );
			redirect( base_url().'my_goal' );

		} elseif( $action == 'update' ) {
			$this->goal_model->updateEmpGoal( $this->goal_id, $this->input->post() );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Your goal has been updated successfully!', 'class' => 'info' ) );
			redirect( base_url().'my_goal' );
		}
	}

	public function update( $goal_id ) {
		# Check user's session
		$this->template_library->check_session( 'user' );
		$this->goal_id = $goal_id;

		if( $this->input->post() )
			$this->save_goals( 'update' );

		$where = array(
						'goal_id' => $goal_id
					  );
		$goal = $this->goal_model->getAllEmpGoal( 
													0
													,1
													,$where
													,'*'
												);
		if( !count( $goal ) ) redirect( base_url().'my_goal' );

		$template_param['goals'] = $goal[0];
		// echo "<pre>";
		// print_r($template_param);
		// exit();
		$template_param['left_side_nav'] = $this->load->view( '_components/left_side_nav', '', true );
		$template_param['action']		 = 'Update Goal';
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
			$this->goal_model->deleteEmpGoal( $db_data );
			
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Your goal has been deleted successfully!', 'class' => 'info' ) );
			echo base_url().'my_goal';
		}
	}

}

/* End of file goals.php */
/* Location: ./application/controllers/goals.php */