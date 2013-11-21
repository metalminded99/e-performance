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
			$where = "ep.date_assigned between '".$this->input->get('date_assinged')." 00:00:00' AND '".$this->input->get('date_assinged2')." 23:59:59'";

			if( $this->input->get('proc_title') ){
				$where .= " AND p.proc_title = '%".addslashes( $this->input->get('proc_title') )."%'";
			}
			if( $this->input->get('lname') ){
				$where .= " AND u.lname like '%".addslashes( $this->input->get('lname') )."%'";
			}
			if( $this->input->get('fname') ){
				$where .= " AND u.fname like '%".addslashes( $this->input->get('fname') )."%'";
			}
			if( $this->input->get('date_accomplised1') ){
				if( $this->input->get('date_accomplised2') )
					$ac2 = $this->input->get('date_accomplised2');
				else
					$ac2 = 'NOW()';

				$where .= "AND ep.date_accomplised between '".$this->input->get('date_accomplised1')."' AND '".$ac2."'";
			}

			$where .= 'AND u.job_id = '. $this->user_job_id;

			$report = $this->process_model->getEmpProcessReport( 
																	$where
																	,$this->input->get('by')
																	,$this->input->get('order')
																);
			$template_param['emp_process'] = $report;
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

	public function appraisal() {
		# Check user's session
		$this->template_library->check_session( 'user' );
		$this->load->model( 'appraisal_model' );

		if($this->input->get()){
			$ap_where = $where = "date_submit between '".$this->input->get('date_submitted')." 00:00:00' AND '".$this->input->get('date_submitted2')." 23:59:59'";

			if( $this->input->get('appraisal_title') ){
				$ap_where .= "AND a.appraisal_title like '%".addslashes( $this->input->get('appraisal_title') )."%'";
			}
			if( $this->input->get('lname') ){
				$where .= " AND u.lname like '%".addslashes( $this->input->get('lname') )."%'";
			}
			if( $this->input->get('fname') ){
				$where .= " AND u.fname like '%".addslashes( $this->input->get('fname') )."%'";
			}

			$results = array();
			$apps = $this->appraisal_model->getSubmittedAppraisal( $ap_where );
			if( $apps->num_rows() > 0 ){
				foreach ($apps->result_array() as $app) {
					$app_users = $this->appraisal_model->getSubmittedAppraisalUsers( $where );
					if ( $app_users->num_rows() > 0 ) {
						foreach ($app_users->result_array() as $app_user) {
							$app_results = $this->appraisal_model->getSubmittedAppraisalResults( array( 'ar.appraisal_id' => $app['appraisal_id'] ) );
							if( $app_results->num_rows() > 0 ){
								foreach ($app_results->result_array() as $app_result) {
									$results[ $app['appraisal_title'] ][ $app_user['full_name'] ][ $app_result['main_category_name'] ][ $app_result['sub_category_name'] ][] = array( 
																					$app_result['question'] => array( 
																									 'self' => $app_result['self_score'] 
																									,'peer' => $app_result['peer_score'] 
																									,'mngr' => $app_result['manager_score'] 
																									) 
																					);
								}
							}
						}
					}
				}
			}
			$template_param['appraisals'] = $results;
		}

		# Template meta data
		$data['active']						= 'appraisal';
		$template_param['emp_menu']			= $this->load->view( '_components/report_menu', $data, true );
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'reports_appraisal';
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