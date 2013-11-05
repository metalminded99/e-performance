<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_goal extends CI_Controller {
	protected $user_id;
	protected $user_job_id;
	protected $goal_id;
	protected $dept_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'goal_model' );

		$this->user_id		= $this->session->userdata( 'user_id' );
		$this->user_job_id	= $this->session->userdata( 'job_id' );
		$this->dept_id 		= $this->session->userdata( 'department_id' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Goal list
		$template_param['p_cnt']		= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Pending' );
		$template_param['pagination']	= $this->template_library->get_pagination(
																					'my_goals' 
																					,$template_param['p_cnt']
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);
		$where = array( 
						 'user_id'	=> $this->user_id
						,'status'	=> 'Pending'
					  );
		$template_param['goals'] = $this->goal_model->getAllEmpGoal( 
																		$offset
																		,PER_PAGE
																		,$where
																	);

		# Template meta data
		$template_param['og_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'On-going' );
		$template_param['co_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Completed' );
		$template_param['w_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Warning' );
		$template_param['ar_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'At Risk' );
		$template_param['r_cnt']	  		= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Rejected' );
		$template_param['heading']			= $this->session->userdata( 'job_title' ).' Goals';
		$template_param['counter']			= $offset;
		$template_param['key']				= 'user_id';
		$template_param['heading']			= 'My Goals';
		$template_param['add_link_text']	= 'Add Goal';

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

	public function on_going( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Goal list
		$template_param['og_cnt']		= $this->goal_model->getTotalEmpGoal( $this->user_id, 'On-going' );
		$template_param['pagination']	= $this->template_library->get_pagination(
																					'my_goals/on_going' 
																					,$template_param['og_cnt']
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(3)) ? $this->uri->segment(3) : 0
																				);
		$where = array( 
						 'user_id'	=> $this->user_id
						,'status'	=> 'On-going'
					  );
		$template_param['goals'] = $this->goal_model->getAllEmpGoal( 
																		$offset
																		,PER_PAGE
																		,$where
																	);

		# Template meta data
		$template_param['p_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Pending' );
		$template_param['co_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Completed' );
		$template_param['w_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Warning' );
		$template_param['ar_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'At Risk' );
		$template_param['r_cnt']	  		= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Rejected' );
		$template_param['heading']			= $this->session->userdata( 'job_title' ).' Goals';
		$template_param['counter']			= $offset;
		$template_param['key']				= 'user_id';
		$template_param['heading']			= 'My Goals';
		$template_param['add_link_text']	= 'Add Goal';

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

	public function warning( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Goal list
		$template_param['w_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Warning' );
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'my_goals/on_going' 
																					,$template_param['w_cnt']
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(3)) ? $this->uri->segment(3) : 0
																				);
		$where = array( 
						 'user_id'	=> $this->user_id
						,'status'	=> 'Warning'
					  );
		$template_param['goals'] = $this->goal_model->getAllEmpGoal( 
																		$offset
																		,PER_PAGE
																		,$where
																	);

		# Template meta data
		$template_param['og_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'On-going' );
		$template_param['p_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Pending' );
		$template_param['ar_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'At Risk' );
		$template_param['co_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Completed' );
		$template_param['r_cnt']	  		= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Rejected' );
		$template_param['heading']			= $this->session->userdata( 'job_title' ).' Goals';
		$template_param['counter']			= $offset;
		$template_param['key']				= 'user_id';
		$template_param['heading']			= 'My Goals';
		$template_param['add_link_text']	= 'Add Goal';

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

	public function at_risk( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Goal list
		$template_param['ar_cnt']		= $this->goal_model->getTotalEmpGoal( $this->user_id, 'At Risk' );
		$template_param['pagination']	= $this->template_library->get_pagination(
																					'my_goals/at_risk' 
																					,$template_param['ar_cnt']
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(3)) ? $this->uri->segment(3) : 0
																				);
		$where = array( 
						 'user_id'	=> $this->user_id
						,'status'	=> 'At Risk'
					  );
		$template_param['goals'] = $this->goal_model->getAllEmpGoal( 
																		$offset
																		,PER_PAGE
																		,$where
																	);

		# Template meta data
		$template_param['og_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'On-going' );
		$template_param['p_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Pending' );
		$template_param['co_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Completed' );
		$template_param['w_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Warning' );
		$template_param['r_cnt']	  		= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Rejected' );
		$template_param['heading']			= $this->session->userdata( 'job_title' ).' Goals';
		$template_param['counter']			= $offset;
		$template_param['key']				= 'user_id';
		$template_param['heading']			= 'My Goals';
		$template_param['add_link_text']	= 'Add Goal';

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

	public function completed( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Goal list
		$template_param['co_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Completed' );
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'my_goals/completed' 
																					,$template_param['co_cnt']
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(3)) ? $this->uri->segment(3) : 0
																				);
		$where = array( 
						 'user_id'	=> $this->user_id
						,'status'	=> 'Completed'
					  );
		$template_param['goals'] = $this->goal_model->getAllEmpGoal( 
																		$offset
																		,PER_PAGE
																		,$where
																	);

		# Template meta data
		$template_param['og_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'On-going' );
		$template_param['p_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Pending' );
		$template_param['w_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Warning' );
		$template_param['ar_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'At Risk' );
		$template_param['r_cnt']	  		= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Rejected' );
		$template_param['heading']			= $this->session->userdata( 'job_title' ).' Goals';
		$template_param['counter']			= $offset;
		$template_param['key']				= 'user_id';
		$template_param['heading']			= 'My Goals';
		$template_param['add_link_text']	= 'Add Goal';

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

	public function rejected( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Goal list
		$template_param['r_cnt']	  = $this->goal_model->getTotalEmpGoal( $this->user_id, 'Rejected' );
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'my_goals/rejected' 
																					,$template_param['r_cnt']
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(3)) ? $this->uri->segment(3) : 0
																				);
		$where = array( 
						 'user_id'	=> $this->user_id
						,'status'	=> 'Rejected'
					  );
		$template_param['goals'] = $this->goal_model->getAllEmpGoal( 
																		$offset
																		,PER_PAGE
																		,$where
																	);

		# Template meta data
		$template_param['co_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Completed' );
		$template_param['og_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'On-going' );
		$template_param['p_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Pending' );
		$template_param['w_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'Warning' );
		$template_param['ar_cnt']			= $this->goal_model->getTotalEmpGoal( $this->user_id, 'At Risk' );
		$template_param['heading']			= $this->session->userdata( 'job_title' ).' Goals';
		$template_param['counter']			= $offset;
		$template_param['key']				= 'user_id';
		$template_param['heading']			= 'My Goals';
		$template_param['add_link_text']	= 'Add Goal';

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

		$template_param['dept_goals'] = $this->goal_model->getAllDeptGoal( 0, 1000, array( 'department_id' => $this->dept_id ) );
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['action']		= 'Add Goal';
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
						'eg.goal_id' => $goal_id
					  );
		$goal = $this->goal_model->getAllEmpGoal( 
													0
													,1
													,$where
												);
		if( !count( $goal ) ) redirect( base_url().'my_goal' );

		$template_param['dept_goals'] = $this->goal_model->getAllDeptGoal( 0, 1000, array( 'department_id' => $this->dept_id ) );
		$template_param['goals'] = $goal[0];
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

	public function check_status() {
		if( $this->input->is_ajax_request() ){
			$db_data = array( 
								'goal_id' => $this->input->post( 'goal_id' )
								,'user_id' => $this->session->userdata( 'user_id' )
							);
			$comment = $this->goal_model->getEmpGoalComment( $db_data );
			echo json_encode($comment[0]);
		}
	}

	public function ajax_request() {
		if( $this->input->is_ajax_request() ){
			if( $this->input->post( 'state' ) != '' ){
				switch ($this->input->post( 'state' )) {
					case 'start':
						$status = 'On-going';
						break;
					case 'complete':
						$status = 'Completed';
						break;
					
					case 'approve':
						$status = 'Pending';
						break;
					
					case 'reject':
						$comment = array( 
											 'goal_id' => $this->input->post( 'goal' )
											,'user_id' => $this->session->userdata( 'user_id' )
											,'comment' => $this->input->post( 'comment' )
										);
						$this->goal_model->addEmpGoalComment( $comment );
						$status = 'Rejected';
						break;
					
					default:
						# code...
						break;
				}

				$db_data = array( 'status'	=> @$status );
				$this->goal_model->updateEmpGoal( $this->input->post( 'goal' ), $db_data );
			}
			
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Goal is now '.$status.'!', 'class' => 'info' ) );
		}
	}

}

/* End of file goals.php */
/* Location: ./application/controllers/goals.php */