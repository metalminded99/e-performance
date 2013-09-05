<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model( 'appraisal_model' );

		$this->user_job_id = $this->session->userdata( 'job_id' );
	}

	public function index(){
		redirec( base_url().'reports/emp_goals' );
	}

	// public function dept_goals() {
	// 	# Check user's session
	// 	$this->template_library->check_session( 'user' );

	// 	# Template meta data
	// 	$data['active']						= 'dgoals';
	// 	$template_param['emp_menu']			= $this->load->view( '_components/report_menu', $data, true );
	// 	$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
	// 	$template_param['content']			= 'reports_index';
	// 	$this->template_library->render( 
	// 										$template_param 
	// 										,'user_header'
	// 										,'user_top'
	// 										,'user_footer'
	// 										,'' 
	// 									);
	// }

	public function emp_goals() {
		# Check user's session
		$this->template_library->check_session( 'user' );
		$this->load->model( 'goal_model' );

		if($this->input->get()){
			$where = "eg.due_date between '".$this->input->get('from_date')."' AND '".$this->input->get('to_date')."'";
			if( $this->input->get('goal_title') ){
				$where .= " AND eg.goal_title = '%".addslashes( $this->input->get('goal_title') )."%'";
			}
			if( $this->input->get('lname') ){
				$where .= " AND u.lname = '%".addslashes( $this->input->get('lname') )."%'";
			}
			if( $this->input->get('fname') ){
				$where .= " AND u.fname like '%".addslashes( $this->input->get('fname') )."'";
			}
			if( $this->input->get('status') && $this->input->get('status') != 'All' ){
				$where .= " AND eg.status = '".$this->input->get('status')."'";
			}

			$report = $this->goal_model->getEmpGoalReport( 
															$where
															,$this->input->get('by')
															,$this->input->get('order')
														 );
			$template_param['emp_goals'] = $report;
		}

		# Template meta data
		$data['active']						= 'egoals';
		$template_param['emp_menu']			= $this->load->view( '_components/report_menu', $data, true );
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'reports_index';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function dev_plans() {
		# Check user's session
		$this->template_library->check_session( 'user' );
		$this->load->model( 'dev_plan_model' );

		if($this->input->get()){
			$where = "ed.date_start between '".$this->input->get('date_start1')."' AND '".$this->input->get('date_start2')."'";
			$where .= "AND ed.date_end between '".$this->input->get('date_end1')."' AND '".$this->input->get('date_end2')."'";

			if( $this->input->get('training_title') ){
				$where .= " AND t.training_title = '%".addslashes( $this->input->get('training_title') )."%'";
			}
			if( $this->input->get('lname') ){
				$where .= " AND u.lname like '%".addslashes( $this->input->get('lname') )."%'";
			}
			if( $this->input->get('fname') ){
				$where .= " AND u.fname like '%".addslashes( $this->input->get('fname') )."%'";
			}
			if( $this->input->get('status') && $this->input->get('status') != 'All' ){
				$where .= " AND ed.status = '".$this->input->get('status')."'";
			}

			$report = $this->dev_plan_model->getEmpDevPlanReport( 
																	$where
																	,$this->input->get('by')
																	,$this->input->get('order')
																);
			$template_param['emp_dev_plans'] = $report;
		}
		# Template meta data
		$data['active']						= 'plan';
		$template_param['emp_menu']			= $this->load->view( '_components/report_menu', $data, true );
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'report_dev_plans';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function process() {
		# Check user's session
		$this->template_library->check_session( 'user' );
		$this->load->model( 'process_model' );

		if($this->input->get()){
			$where = "ed.date_start between '".$this->input->get('date_start1')."' AND '".$this->input->get('date_start2')."'";
			$where .= "AND ed.date_end between '".$this->input->get('date_end1')."' AND '".$this->input->get('date_end2')."'";

			if( $this->input->get('training_title') ){
				$where .= " AND t.training_title = '%".addslashes( $this->input->get('training_title') )."%'";
			}
			if( $this->input->get('lname') ){
				$where .= " AND u.lname like '%".addslashes( $this->input->get('lname') )."%'";
			}
			if( $this->input->get('fname') ){
				$where .= " AND u.fname like '%".addslashes( $this->input->get('fname') )."%'";
			}
			if( $this->input->get('status') && $this->input->get('status') != 'All' ){
				$where .= " AND ed.status = '".$this->input->get('status')."'";
			}

			$report = $this->dev_plan_model->getEmpDevPlanReport( 
																	$where
																	,$this->input->get('by')
																	,$this->input->get('order')
																);
			$template_param['emp_dev_plans'] = $report;
		}

		# Template meta data
		$data['active']						= 'proc';
		$template_param['emp_menu']			= $this->load->view( '_components/report_menu', $data, true );
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'reports_process';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

}

/* End of file appraisal.php */
/* Location: ./application/controllers/appraisal.php */