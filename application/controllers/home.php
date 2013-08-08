<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		# Check user's session
		$this->template_library->check_session( 'user' );

		$this->load->model( 'news_model' );
		$this->load->model( 'history_model' );
		$this->load->model( 'goal_model' );
		$this->load->model( 'dev_plan_model' );
		$this->load->model( 'appraisal_model' );

		$data['news'] = $this->news_model->getActiveNews();
		$data['history'] = $this->history_model->getUserLogs( $this->session->userdata('user_id') );
		$template_param['goal_noti']				= $this->goal_model->getEmpGoalReminder( $this->session->userdata( 'user_id' ) );
		$template_param['trainings_noti']			= $this->dev_plan_model->getEmpDevPlanReminder( $this->session->userdata( 'user_id' ) );
		
		$self_feedback 								= $this->appraisal_model->getSelfFeedbackCount( $this->session->userdata( 'user_id' ) );
		$peer_feedback 								= $this->appraisal_model->getPeerFeedbackCount( $this->session->userdata( 'user_id' ) );
		$mngr_feedback 								= $this->appraisal_model->getMngrFeedbackCount( $this->session->userdata( 'user_id' ) );
		$template_param['feedback_noti']			= $self_feedback + $peer_feedback + $mngr_feedback;

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

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
