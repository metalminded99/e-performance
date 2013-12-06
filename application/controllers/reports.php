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

	public function potential() {
		# Check user's session
		$this->template_library->check_session( 'user' );
		$this->load->model( 'potential_appraisal_model' );

		if($this->input->get()){
			$where = "p.date_submit between '".$this->input->get('date_submit1')."' AND '".$this->input->get('date_submit2')."'";

			if( $this->input->get('lname') ){
				$where .= " AND u.lname like '%".addslashes( $this->input->get('lname') )."%'";
			}
			if( $this->input->get('fname') ){
				$where .= " AND u.fname like '%".addslashes( $this->input->get('fname') )."%'";
			}

			$report = $this->potential_appraisal_model->getPotentialAppraisalReport( 
																				$where
																				,$this->input->get('by')
																				,$this->input->get('order')
																			);
			$potentials = array();
			for ( $i=0; $i < count($report); $i++) {
				if( $report[$i]['ave'] >= 85 ){
					$potentials[] = $report[$i];
				}
			}
			$template_param['potentials'] = $potentials;
		}
		# Template meta data
		$data['active']						= 'potential';
		$template_param['emp_menu']			= $this->load->view( '_components/report_menu', $data, true );
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'report_potential';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function training_needs() {
		# Check user's session
		$this->template_library->check_session( 'user' );
		$this->load->model( 'appraisal_model' );

		if($this->input->get()){
			$main_cat = $this->appraisal_model->getAppraisalMainCategories();
			$report = array();
			if( count($main_cat) > 0 ){
				foreach ($main_cat as $mc) {
					$sub_cat = $this->appraisal_model->getAppraisalSubCatReport( array( 
																						 'main_cat_id' 	  => $mc['main_category_id']
																						,'date_submit >=' => $this->input->get('date_submit1')
																						,'date_submit <=' => $this->input->get('date_submit2')
																					  ) 
																				);
					if( $sub_cat->num_rows() > 0 ){
						foreach ($sub_cat->result_array() as $sc) {
							$report[ $mc['main_category_name'] ][] = $sc;
						}
					}
				}
			}
			$template_param['needs'] = $report;
		}
		# Template meta data
		$data['active']						= 'training_needs';
		$template_param['emp_cnt']			= $this->appraisal_model->getAppraisalEmployeeCnt( $this->session->userdata('job_id') );;
		$template_param['emp_menu']			= $this->load->view( '_components/report_menu', $data, true );
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'report_traning_needs';
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
			$ap_where = $where = "ar.date_submit between '".$this->input->get('date_submitted')." 00:00:00' AND '".$this->input->get('date_submitted2')." 23:59:59'";

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
			$_quest = array();
			$apps = $this->appraisal_model->getAppraisalSummary( $ap_where );
			if( $apps->num_rows() > 0 ){
				foreach ($apps->result_array() as $app) {
					$percentage		= $app['percentage'] / 100;
					$cat_ave		= ((((($app['self_ave'] + $app['peer_ave']) + $app['mngr_ave']) / 3) / 5) * 100) * $percentage;
					@$ave[$app['appraisal_id']]		+= $cat_ave;
					$app_users = $this->appraisal_model->getSubmittedAppraisalUsers( $where );
					if ( $app_users->num_rows() > 0 ) {
						foreach ($app_users->result_array() as $app_user) {
							$app_sub_cats = $this->appraisal_model->getAppraisalSummarySubCat( array( 'ar.appraisal_id' => $app['appraisal_id'] ) );
							if( $app_sub_cats->num_rows() > 0 ){
								foreach ($app_sub_cats->result_array() as $app_sub_cat) {
									$q_param = array(
														 'ar.appraisal_id' 	=> $app['appraisal_id']
														,'aq.category'		=> $app['main_category_id']
														,'aq.sub_category' 	=> $app_sub_cat['sub_category_id']

													);
									$app_questions = $this->appraisal_model->getAppraisalSummaryQuestions( $q_param );
									if( $app_questions->num_rows() > 0 ){
										foreach ($app_questions->result_array() as $app_question) {
											if( !in_array($app_question['question'], $_quest ) ){
												$main_cat = $cat_ave > 0 ? number_format($cat_ave, 1) .'% / '. $app['percentage'] . '%' : 'N/A';
												$results[ $app['appraisal_id'].'_'.$app['appraisal_title'] ][ $app_user['full_name'] . '_' . $app_user['job_title'] ][ $app['main_category_name'] . ' (' .$main_cat. ')' ][ $app_sub_cat['sub_category_name'] ][] = array( 
																						$app_question['question'] => array( 
																										 'self' => $app_question['self_score']
																										,'peer' => $app_question['peer_score']
																										,'mngr' => $app_question['manager_score'] 
																										) 
																						);
												$_quest[] = $app_question['question' ];
											}
										}
									}
								}
							}
						}
					}
					$template_param['overall'] = $ave;
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