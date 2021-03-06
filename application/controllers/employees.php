<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends CI_Controller {
	protected $user_id;
	protected $user_job_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'employees_model' );

		$this->user_id		= $this->session->userdata( 'user_id' );
		$this->user_job_id	= $this->session->userdata( 'job_id' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Employee list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'employees' 
																					,$this->employees_model->getTotalEmployees( array( 'job_id' => $this->user_job_id ) )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);
		$where = array( 
						'U.job_id' => $this->user_job_id
						,'U.lvl ' => 3 
					  );
		$template_param['employees'] = $this->employees_model->getAllEmployees( 
																				$offset
																				,PER_PAGE
																				,$where
																			  );

		# Template meta data
		$template_param['heading']			= $this->session->userdata( 'job_title' ).' Employees';
		$template_param['table_heading']	= array(
														'Employee Name'
														,'Employee Description'
														,'Active'
													);
		$template_param['add_link']			= base_url().'employees/add';
		$template_param['delete_url']		= base_url().'employees/delete';
		$template_param['update_url']		= base_url().'employees/update';
		$template_param['add_link_text']	= 'Add Employee';
		$template_param['counter']	= $offset;
		$template_param['key']	= 'user_id';


		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['attr_selection']	= $this->get_employees_list();
		$template_param['content']			= 'templates/employee_template';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function info( $user_id ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Employee job attribute
		$this->load->model( 'skills_model' );
		$this->load->model( 'abilities_model' );
		$this->load->model( 'activities_model' );
		$this->load->model( 'duties_model' );

		$template_param['skills']		= $this->skills_model->getAllJobSkills( 0, 1000, array( 'job_id' => $this->user_job_id ) );
		$template_param['abilities']	= $this->abilities_model->getAllJobAbilities( 0, 1000, array( 'job_id' => $this->user_job_id ) );
		$template_param['activities']	= $this->activities_model->getAllJobActivities( 0, 1000, array( 'job_id' => $this->user_job_id ) );
		$template_param['duties']		= $this->duties_model->getAllJobDuties( 0, 1000, array( 'job_id' => $this->user_job_id ) );
		$data['active'] = 'info';
		$data['user_id'] = $user_id;
		$template_param['emp_menu'] = $this->load->view( '_components/emp_menu', $data, true );

		# Employee info
		$emp_details = $this->employees_model->getAllEmployees( 0, 1, array( 'U.user_id' => $user_id ) );
		$template_param['employee'] = count( $emp_details ) > 0 ? $emp_details[0] : array();

		# Template meta data
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'employee_info';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,''
										);
	}

	public function goals( $user_id, $offset = 0 ) { 
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Employee goals
		$this->load->model( 'goal_model' );
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'employees/info/goals/'.$user_id 
																					,$this->goal_model->getTotalEmpGoal( $user_id )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(5)) ? $this->uri->segment(5) : 0
																				);

		$template_param['goals']	= $this->goal_model->getAllEmpGoal( $offset, PER_PAGE, array( 'user_id' => $user_id ), '*' );

		$data['active'] = 'goals';
		$data['user_id'] = $user_id;
		$template_param['emp_menu'] = $this->load->view( '_components/emp_menu', $data, true );

		# Template meta data
		$template_param['user_id']			= $user_id;
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
	
	public function goal_update() {
		if( $this->input->is_ajax_request() ) {
			$this->load->model( 'goal_model' );
			$goals = $this->input->post( 'item' );

			for( $g = 0; $g < count( $goals ); $g++ ){
				$this->goal_model->updateEmpGoal( $goals[ $g ], array( 'status' => $this->input->post( 'state' ) ) );
			}	
		}
		$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Employee\'s goal has been updated successfully!', 'class' => 'info' ) );
		echo base_url().'employees/info/goals/'.$this->input->post( 'user' );
	}

	public function dev_plan( $user_id, $offset = 0 ) { 
		# Check user's session
		$this->template_library->check_session( 'user' );

		$this->load->model( 'dev_plan_model' );
		$this->load->model( 'trainings_model' );

		$template_param['save_url'] = base_url().'employees/save_trainings';
		$template_param['action_url'] = base_url().'employees/info/dev_plan/update';
		$trainings = $this->trainings_model->getAllTrainings( 0, 1000 );
		$t = array();
		if( count($trainings) > 0 ){
			for ($i=0; $i < count( $trainings ); $i++) { 
				$t_s['t_skills'] = $this->trainings_model->getTrainingSkills( $trainings[$i]['training_id'], 'S.skill_name' );
				$t_a['t_abilities'] = $this->trainings_model->getTrainingAbilities( $trainings[$i]['training_id'], 'A.ability_name' );

				$t[] = array_merge( $trainings[ $i ], $t_s, $t_a );
			}
		}

		$template_param['trainings'] = json_encode( $t );

		# Employee dev plan
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'employees/info/dev_plan/'.$user_id 
																					,$this->dev_plan_model->getTotalDevPlan( $user_id )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(5)) ? $this->uri->segment(5) : 0
																				);
		$dev_plans = array();
		$trainings = $this->dev_plan_model->getAllDevPlan( $offset, PER_PAGE, array( 'user_id' => $user_id ) );
		if( count( $trainings ) > 0 ){
			for ($i=0; $i < count( $trainings ); $i++) { 
				$t_skills['t_skills'] = $this->dev_plan_model->getDevPlanSkills( $trainings[ $i ]['training_id'] );
				$t_abilities['t_abilities'] = $this->dev_plan_model->getDevPlanAbilities( $trainings[ $i ]['training_id'] );
				$dev_plans[] = array_merge( $trainings[ $i ], $t_skills, $t_abilities );
			}
		}
		$template_param['dev_plans'] = $dev_plans;
		$data['active'] = 'plan';
		$data['user_id'] = $user_id;
		$template_param['emp_menu'] = $this->load->view( '_components/emp_menu', $data, true );

		# Template meta data
		$template_param['delete_url']		= base_url().'employees/dev_plan_delete';
		$template_param['update_url']		= base_url().'employees/dev_plan_update';
		$template_param['user_id']			= $user_id;
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'dev_plans';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,''
										);
	}

	public function save_trainings(){
		$this->load->model( 'dev_plan_model' );

		$start_date = $this->input->post( 'date_start' );
		$end_date = $this->input->post( 'date_end' );

		$training = array( 
							'training_id'	=> $this->input->post( 'training_id' )
							,'date_start'	=> $start_date
							,'date_end'		=> $end_date
							,'user_id'		=> $this->input->post( 'user_id' )
							,'status'		=> 'Pending'
						 );

		$this->dev_plan_model->saveNewEmpDevPlan( $training );

		$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> New training has been added successfully!', 'class' => 'info' ) );
		redirect( base_url().'employees/info/dev_plan/'.$this->input->post( 'user_id' ) );
	}

	public function dev_plan_update() {
		$this->load->model( 'dev_plan_model' );

		$t_id = $this->input->post( 't_id' );
		$training = array( 							
							'date_start'	=> $this->input->post( 'date_start' )
							,'date_end'		=> $this->input->post( 'date_end' )
						 );

		$this->dev_plan_model->updateEmpDevPlan( $t_id, $training );

		$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Employee\'s training has been updated successfully!', 'class' => 'info' ) );

		redirect( base_url().'employees/info/dev_plan/'.$this->input->post( 'user_id' ) );
	}

	public function dev_plan_delete() {
		if( $this->input->is_ajax_request() ) {
			$this->load->model( 'dev_plan_model' );

			$this->dev_plan_model->deleteEmpDevPlan( $this->input->post( 'training_id' ) );
		}
		
		$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Employee\'s training has been removed successfully!', 'class' => 'info' ) );

		echo base_url().'employees/info/dev_plan/'.$this->input->post( 'user' );
	}

	public function get_employees_list() {
		$data['save_url'] = base_url().'employees/save_employees';
		$data['attr_list'] = $this->employees_model->getAllEmployees( 0, 1000 );
		return $this->load->view( 'templates/attribute_list_template', $data, true );
	}

	public function journals( $user_id, $offset = 0 ) { 
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Employee journals
		$this->load->model( 'journals_model' );
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'employees/info/journals/'.$user_id 
																					,$this->journals_model->getTotalJournals( $user_id )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(5)) ? $this->uri->segment(5) : 0
																				);

		$template_param['journals']	= $this->journals_model->getAllJournals( $offset, PER_PAGE, array( 'user_id' => $user_id ) );

		$data['active'] = 'journal';
		$data['user_id'] = $user_id;
		$template_param['emp_menu'] = $this->load->view( '_components/emp_menu', $data, true );

		# Template meta data
		$template_param['counter']			= $offset;
		$template_param['user_id']			= $user_id;
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'employee_journals';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,''
										);
	}
	
	public function journals_update() {
		if( $this->input->is_ajax_request() ) {
			$this->load->model( 'journals_model' );
			$goals = $this->input->post( 'item' );

			for( $g = 0; $g < count( $goals ); $g++ ){
				$this->journals_model->updateEmpGoal( $goals[ $g ], array( 'status' => $this->input->post( 'state' ) ) );
			}	
		}
		$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Employee\'s goal has been updated successfully!', 'class' => 'info' ) );
		echo base_url().'employees/info/goals/'.$this->input->post( 'user' );
	}

}

/* End of file employees.php */
/* Location: ./application/controllers/employees.php */