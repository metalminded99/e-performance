<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	protected $dept;

	public function __construct() {
		parent::__construct();

		$this->dept = $this->session->userdata( 'department_id' );
	}

	public function index() {
		# Check user's session
		$this->template_library->check_session( 'user' );

		$this->load->model( 'news_model' );
		$this->load->model( 'history_model' );
		$this->load->model( 'goal_model' );
		$this->load->model( 'dev_plan_model' );
		$this->load->model( 'appraisal_model' );
		$this->load->model( 'process_model' );

		if( $this->session->userdata('lvl') == 2 ){
			$mngr_summary = array();
			$mngr_view = $this->appraisal_model->getMngrViewSummary( $this->dept );
			foreach ($mngr_view as $e_app) {
				$mngr_summary[ $e_app['full_name'] ][ $e_app['category'] ] = number_format( $e_app['total_score'], 1);
			}
			$template_param['mngr_summary'] = !empty( $mngr_summary ) ? json_encode( $mngr_summary ) : 0 ;
		}

		// $data['news']						= $this->news_model->getActiveNews();
		$data['history']					= $this->history_model->getUserLogs( $this->session->userdata('user_id') );
		
		# Notifications start
		$template_param['goal_noti']		= $this->goal_model->getEmpGoalReminder( $this->session->userdata( 'user_id' ) );
		$template_param['trainings_noti']	= $this->dev_plan_model->getEmpDevPlanReminder( $this->session->userdata( 'user_id' ) );
		$template_param['process_noti']		= $this->process_model->getProcessReminder( $this->session->userdata( 'user_id' ) );
		
		$self_feedback 	= $this->appraisal_model->getSelfFeedbackCount( $this->session->userdata( 'user_id' ) );
		$peer_feedback 	= $this->appraisal_model->getPeerFeedbackCount( $this->session->userdata( 'user_id' ) );
		$mngr_feedback = 0;
		if( $this->session->userdata('lvl') == 2 )
			$mngr_feedback 								= $this->appraisal_model->getMngrFeedbackCount( $this->session->userdata( 'user_id' ) );

		$template_param['feedback_noti']			= $self_feedback + $peer_feedback + $mngr_feedback;
		# Notifications end

		$self_score		= $this->appraisal_model->getFeedbackSummary( 'self_score', array( 'user_id' => $this->session->userdata( 'user_id' ) ) );
		$peer_score		= $this->appraisal_model->getFeedbackSummary( 'peer_score', array( 'user_id' => $this->session->userdata( 'user_id' ) ) );
		$manager_score	= $this->appraisal_model->getFeedbackSummary( 'manager_score', array( 'user_id' => $this->session->userdata( 'user_id' ) ) );

		# Performance and score chart data start
		$p_where = $this->session->userdata('lvl') == 2 ? null : array( 'user_id' => $this->session->userdata( 'user_id' ) );
		$score_summary	= $this->appraisal_model->getPerformanceSummary( $p_where );
		$performance = array();
		$months = range(1, 12);
		if( count($score_summary) > 0 ){
			foreach ($score_summary as $ss) {
				for( $i=0; $i < count($months); $i++ ){
					$performance[ $ss['dsy'] ][ $months[$i] ] = $ss['dsm'] == $months[$i] ? (($ss['sc'] + $ss['ps'] + $ss['ms']) / 3) : 0;
				}
			}
		}
		
		$template_param['performance_summary']		= !empty( $performance ) ? json_encode( $performance ) : 0 ;
		# Performance and score chart data end

		# Goals chart data start
		$g_where = array();
		if( $this->session->userdata('lvl') == 3 )
			$g_where = array( 'user_id' => $this->session->userdata( 'user_id' ) );

		$goal_status	= array( 'Pending','On-going','Completed','Warning','At Risk','Late','Rejected' );
		$dept_goals		= $this->goal_model->getAllDeptGoal( 0, 10000, array( 'department_id' => $this->dept ) );
		$goal_summary	= array();
		foreach ($dept_goals as $dept_goal) {
			for( $i=0; $i < count( $goal_status ); $i++ ){
				$where = array( 'dg.goal_id' => $dept_goal['goal_id'], 'status' => $goal_status[$i] );
				$goals = $this->goal_model->getGoalSummary( array_merge($g_where, $where) );
				$goal_summary[ $dept_goal['goal_title'] ][ $goal_status[$i] ] = isset( $goals[0]['total'] ) ? intval( $goals[0]['total'] ) : 0 ;
			}
		}
		$template_param['goals_summary']			= !empty( $goal_summary ) ? json_encode( $goal_summary ) : 0 ;
		# Goals chart data end

		# Process chart data start
		$proc_status	= $template_param['proc_status'] = array( 'Pending','On-going','Completed','Rejected' );
		$processes		= $this->process_model->getAllProcess( 0, 10000 );
		$proc_summary	= array();
		foreach ($dept_goals as $dept_goal) {
			for( $i=0; $i < count( $goal_status ); $i++ ){
				$where = array( 'dg.goal_id' => $dept_goal['goal_id'], 'status' => $goal_status[$i] );
				$goals = $this->goal_model->getGoalSummary( array_merge($g_where, $where) );
				$goal_summary[ $dept_goal['goal_title'] ][ $goal_status[$i] ] = isset( $goals[0]['total'] ) ? intval( $goals[0]['total'] ) : 0 ;
			}
		}
		$template_param['goals_summary']			= !empty( $goal_summary ) ? json_encode( $goal_summary ) : 0 ;
		# Process chart data end

		$template_param['left_side_nav']			= $this->load->view( '_components/left_side_nav', '', true );
		// $template_param['user_notifications']		= $this->load->view( '_components/user_notifications', '', true );
		// $template_param['user_dashboard']			= $this->load->view( '_components/user_dashboard', '', true );
		$template_param['user_widgets']				= $this->load->view( 'templates/news_widget', $data, true );
		$template_param['content']					= 'templates/user_template';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function acct_setting( $user_id ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		$this->load->model( 'skills_model' );
		$this->load->model( 'abilities_model' );
		$this->load->model( 'activities_model' );
		$this->load->model( 'duties_model' );

		$template_param['skills']		= $this->skills_model->getAllJobSkills( 0, 1000, array( 'job_id' => $this->session->userdata( 'job_id' ) ) );
		$template_param['abilities']	= $this->abilities_model->getAllJobAbilities( 0, 1000, array( 'job_id' => $this->session->userdata( 'job_id' ) ) );
		$template_param['activities']	= $this->activities_model->getAllJobActivities( 0, 1000, array( 'job_id' => $this->session->userdata( 'job_id' ) ) );
		$template_param['duties']		= $this->duties_model->getAllJobDuties( 0, 1000, array( 'job_id' => $this->session->userdata( 'job_id' ) ) );

		$template_param['left_side_nav']			= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']					= 'acct_setting';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function change_password() {
		if( $this->input->post() ){
			$this->load->model( 'login_model' );

			$old_pword = array( 'pword' => md5($this->input->post('oldpword')) );
			$new_pword = array( 'pword' => md5($this->input->post('newpword')) );
			$user_id = array( 'user_id' => $this->session->userdata( 'user_id' ) );

			$check = $this->login_model->checkUserPassword( array_merge( $old_pword, $user_id ) );
			if( $check ) {
				$this->login_model->changePassword( $new_pword, $user_id );

				$this->session->set_flashdata( 
												'message'
												,array( 
														'str'		=> '<i class="icon-ok"></i> Password has been changed successfully!'
														,'class'	=> 'info' 
													  ) 
											);
			} else {
				$this->session->set_flashdata( 
												'message'
												,array( 
														'str'		=> '<i class="icon-exclamation-sign"></i> Please enter your correct old password!'
														,'class'	=> 'error' 
													  ) 
											);
			}
			redirect( base_url().'acct_setting/'.$this->session->userdata( 'user_id' ) );
		}
	}

	public function update_contact() {
		if( $this->input->post() ){
			$this->load->model( 'login_model' );

			$where = array( 'user_id' => $this->session->userdata( 'user_id' ) );
			$this->login_model->updateUserContacts( $where, $this->input->post() );
			$this->session->set_flashdata( 
											'message'
											,array( 
													'str'		=> '<i class="icon-ok"></i> Contacts has been updated successfully!'
													,'class'	=> 'info' 
												  ) 
										);
			foreach ($this->input->post() as $key => $val) {
				$this->session->set_userdata( $key, $val );
			}
			
			redirect( base_url().'acct_setting/'.$this->session->userdata( 'user_id' ) );
		}
	}

	public function ajax_request() {
		$this->load->model( 'process_model' );
		if( $this->input->is_ajax_request() ){
			if( $this->input->post('action') == 'get_process' ) {
				$stats 		 = $this->process_model->getProcessSummary( $this->input->post('proc_stat') );
				$stats_array = array();
				foreach ($stats as $stat) {
					$stats_array[ $stat[ 'proc_title' ] ] =  $stat[ 'total' ];
				} 

				echo json_encode( $stats_array );
			}
		}else
			redirect( base_url() );
	}

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
