<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_trainings extends CI_Controller {
	protected $user_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'dev_plan_model' );
		$this->load->model( 'trainings_model' );

		$this->user_id = $this->session->userdata( 'user_id' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Employee dev plan
		$template_param['p_cnt']	= $this->dev_plan_model->getTotalDevPlan( $this->user_id, 'Pending' );
		$template_param['og_cnt']	= $this->dev_plan_model->getTotalDevPlan( $this->user_id, 'On-going' );
		$template_param['co_cnt']	= $this->dev_plan_model->getTotalDevPlan( $this->user_id, 'Completed' );
		$template_param['c_cnt']	= $this->dev_plan_model->getTotalDevPlan( $this->user_id, 'Cancelled' );
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'my_trainings/index'
																					,$template_param['p_cnt']
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);
		$trainings = $this->dev_plan_model->getAllDevPlan( $offset, PER_PAGE, array( 'user_id' => $this->user_id, 'status' => 'Pending' ) );
		if( count( $trainings ) > 0 ){
			for ($i=0; $i < count( $trainings ); $i++) { 
				$t_skills['t_skills'] = $this->dev_plan_model->getDevPlanSkills( $trainings[ $i ]['training_id'] );
				$t_abilities['t_abilities'] = $this->dev_plan_model->getDevPlanAbilities( $trainings[ $i ]['training_id'] );
				$dev_plans[] = array_merge( $trainings[ $i ], $t_skills, $t_abilities );
			}
		}
		$template_param['dev_plans'] = $dev_plans;
		$template_param['action_url'] = base_url().'my_trainings/update';
		# Template meta data
		$trainings = $this->trainings_model->getAllTrainings( 0, 1000 );
		$t = array();
		if( count($trainings) > 0 ){
			for ($i=0; $i < count( $trainings ); $i++) { 
				$t_s['t_skills'] = $this->trainings_model->getTrainingSkills( $trainings[$i]['training_id'], 'S.skill_name' );
				$t_a['t_abilities'] = $this->trainings_model->getTrainingAbilities( $trainings[$i]['training_id'], 'A.ability_name' );

				$t[] = array_merge( $trainings[ $i ], $t_s, $t_a );
			}
		}

		$template_param['trainings']		= json_encode( $t );
		$template_param['update_url']		= base_url().'my_trainings/update';
		$template_param['user_id']			= $this->user_id;
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

	public function on_going( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Employee dev plan
		$template_param['p_cnt']	= $this->dev_plan_model->getTotalDevPlan( $this->user_id, 'Pending' );
		$template_param['og_cnt']	= $this->dev_plan_model->getTotalDevPlan( $this->user_id, 'On-going' );
		$template_param['co_cnt']	= $this->dev_plan_model->getTotalDevPlan( $this->user_id, 'Completed' );
		$template_param['c_cnt']	= $this->dev_plan_model->getTotalDevPlan( $this->user_id, 'Cancelled' );
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'my_trainings/on_going'
																					,$template_param['og_cnt']
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(3)) ? $this->uri->segment(3) : 0
																				);
		$dev_plans = array();
		$trainings = $this->dev_plan_model->getAllDevPlan( $offset, PER_PAGE, array( 'user_id' => $this->user_id, 'status' => 'On-going' ) );
		if( count( $trainings ) > 0 ){
			for ($i=0; $i < count( $trainings ); $i++) { 
				$t_skills['t_skills'] = $this->dev_plan_model->getDevPlanSkills( $trainings[ $i ]['training_id'] );
				$t_abilities['t_abilities'] = $this->dev_plan_model->getDevPlanAbilities( $trainings[ $i ]['training_id'] );
				$dev_plans[] = array_merge( $trainings[ $i ], $t_skills, $t_abilities );
			}
		}
		$template_param['dev_plans'] = $dev_plans;
		$template_param['action_url'] = base_url().'my_trainings/update';
		# Template meta data
		$trainings = $this->trainings_model->getAllTrainings( 0, 1000 );
		$t = array();
		if( count($trainings) > 0 ){
			for ($i=0; $i < count( $trainings ); $i++) { 
				$t_s['t_skills'] = $this->trainings_model->getTrainingSkills( $trainings[$i]['training_id'], 'S.skill_name' );
				$t_a['t_abilities'] = $this->trainings_model->getTrainingAbilities( $trainings[$i]['training_id'], 'A.ability_name' );

				$t[] = array_merge( $trainings[ $i ], $t_s, $t_a );
			}
		}

		$template_param['trainings']		= json_encode( $t );
		$template_param['update_url']		= base_url().'my_trainings/update';
		$template_param['user_id']			= $this->user_id;
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

	public function completed( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Employee dev plan
		$template_param['p_cnt']	= $this->dev_plan_model->getTotalDevPlan( $this->user_id, 'Pending' );
		$template_param['og_cnt']	= $this->dev_plan_model->getTotalDevPlan( $this->user_id, 'On-going' );
		$template_param['co_cnt']	= $this->dev_plan_model->getTotalDevPlan( $this->user_id, 'Completed' );
		$template_param['c_cnt']	= $this->dev_plan_model->getTotalDevPlan( $this->user_id, 'Cancelled' );
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'my_trainings/completed'
																					,$template_param['co_cnt']
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(3)) ? $this->uri->segment(3) : 0
																				);

		$trainings = $this->dev_plan_model->getAllDevPlan( $offset, PER_PAGE, array( 'user_id' => $this->user_id, 'status' => 'Completed' ) );
		if( count( $trainings ) > 0 ){
			for ($i=0; $i < count( $trainings ); $i++) { 
				$t_skills['t_skills'] = $this->dev_plan_model->getDevPlanSkills( $trainings[ $i ]['training_id'] );
				$t_abilities['t_abilities'] = $this->dev_plan_model->getDevPlanAbilities( $trainings[ $i ]['training_id'] );
				$dev_plans[] = array_merge( $trainings[ $i ], $t_skills, $t_abilities );
			}
		}
		$template_param['dev_plans'] = $dev_plans;
		$template_param['action_url'] = base_url().'my_trainings/update';
		# Template meta data
		$trainings = $this->trainings_model->getAllTrainings( 0, 1000 );
		$t = array();
		if( count($trainings) > 0 ){
			for ($i=0; $i < count( $trainings ); $i++) { 
				$t_s['t_skills'] = $this->trainings_model->getTrainingSkills( $trainings[$i]['training_id'], 'S.skill_name' );
				$t_a['t_abilities'] = $this->trainings_model->getTrainingAbilities( $trainings[$i]['training_id'], 'A.ability_name' );

				$t[] = array_merge( $trainings[ $i ], $t_s, $t_a );
			}
		}

		$template_param['trainings']		= json_encode( $t );
		$template_param['update_url']		= base_url().'my_trainings/update';
		$template_param['user_id']			= $this->user_id;
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

	public function add() {
		# Check user's session
		$this->template_library->check_session( 'user' );

		if( $this->input->post() )
			$this->save_trainings( 'add' );

		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['action']		= 'Add New Training';
		$template_param['content']		= 'add_training';

		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function save_trainings( $action ) {		
		if( $action == 'add' ){

			$user = array( 'user_id' => $this->user_id );
			$this->dev_plan_model->saveNewEmpTraining( array_merge( $user, $this->input->post() ) );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> New training has been added successfully!', 'class' => 'info' ) );
			redirect( base_url().'my_trainings' );

		} elseif( $action == 'update' ) {
			$this->dev_plan_model->updateEmpTraining( $this->training_id, $this->input->post() );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Your training has been updated successfully!', 'class' => 'info' ) );
			redirect( base_url().'my_trainings' );
		}
	}

	public function update() {
		if( $this->input->is_ajax_request() ){
			$items = $this->input->post( 'item' );
			if( $items ){
				for( $i = 0; $i < count( $items ); $i++ ){
					$param = array( 
									'user_id' => $this->user_id
									,'status' => $this->input->post( 'state' )
								  );
					$this->dev_plan_model->updateEmpDevPlan( $items[$i], $param );
				}
			}

			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Skills has been updated successfully!', 'class' => 'info' ) );
			echo base_url().'my_trainings';
		}
	}

	public function delete() {
		if( $this->input->is_ajax_request() ){
			$db_data = array( 'training_id' => $this->input->post( 'training_id' ) );
			$this->dev_plan_model->deleteEmpTraining( $db_data );
			
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Your training has been deleted successfully!', 'class' => 'info' ) );
			echo base_url().'my_trainings';
		}
	}

	public function ajax_request() {
		if( $this->input->is_ajax_request() ){
			$action = $this->input->post('action');
			switch ($action) {
				case 'on_going':
					$param = array( 
									'user_id' => $this->user_id
									,'status' => 'On-going'
								  );
					$this->dev_plan_model->updateEmpDevPlan( $this->input->post( 'training' ), $param );
					break;
				
				case 'completed':
					$param = array( 
									'user_id' => $this->user_id
									,'status' => 'Completed'
								  );
					$this->dev_plan_model->updateEmpDevPlan( $this->input->post( 'training' ), $param );
					break;
				
				default:
					# code...
					break;
			}

			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Training is now '.$param['status'].'!', 'class' => 'info' ) );
		}
	}

}

/* End of file trainings.php */
/* Location: ./application/controllers/trainings.php */