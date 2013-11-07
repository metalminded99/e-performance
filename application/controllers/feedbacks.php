<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedbacks extends CI_Controller {
	protected $user_id;
	protected $user_job_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'appraisal_model' );

		$this->user_id = $this->session->userdata( 'user_id' );
		$this->user_job_id = $this->session->userdata( 'job_id' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		if( $this->session->userdata( 'lvl' ) == 2 )
			redirect( base_url().'feedbacks/mngr' );

		# Appraisal list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'feedbacks' 
																					,$this->appraisal_model->getSelfFeedbackCount( $this->user_id )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);

		$template_param['feedbacks'] = $this->appraisal_model->getSelfFeedback( $offset, PER_PAGE, array( 'user_id' => $this->user_id ) );

		# Template meta data
		$template_param['heading']	= 'My Feedbacks';
		$template_param['category'] = $data['active'] = 'self';
		$template_param['app_menu'] = $this->load->view( '_components/app_menu', $data, true );
		$template_param['counter']	= $offset;

		$template_param['left_side_nav'] = $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']		 = 'self_feedbacks';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function peer( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Appraisal list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'feedbacks/peer' 
																					,$this->appraisal_model->getPeerFeedbackCount( $this->user_id )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(3)) ? $this->uri->segment(3) : 0
																				);

		$template_param['feedbacks'] = $this->appraisal_model->getPeerFeedback( $offset, PER_PAGE, array( 'peer_id' => $this->user_id ) );
		# Template meta data
		$template_param['heading']	= 'Peer Feedbacks';
		$template_param['category'] = $data['active'] = 'peer';
		$template_param['app_menu'] = $this->load->view( '_components/app_menu', $data, true );
		$template_param['counter']	= $offset;

		$template_param['left_side_nav'] = $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']		 = 'peer_feedbacks';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function mngr( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Appraisal list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'feedbacks/mngr' 
																					,$this->appraisal_model->getMngrFeedbackCount( $this->user_id )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(3)) ? $this->uri->segment(3) : 0
																				);

		$template_param['feedbacks'] = $this->appraisal_model->getMngrFeedback( $offset, PER_PAGE, array( 'manager_id' => $this->user_id ) );
		# Template meta data
		$template_param['category'] = $data['active'] = 'mngr';
		$template_param['app_menu'] = $this->load->view( '_components/app_menu', $data, true );
		$template_param['counter']	= $offset;

		$template_param['left_side_nav'] = $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']		 = 'mngr_feedbacks';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function feedback_question( $app_id, $assign = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		$step = $this->input->post( 'step' ) != '' ?  $this->input->post( 'step' ) : 0;
		$cat = $this->appraisal_model->getAppraisalMainCategories( array( 'job_id' => $this->user_job_id ) );

		if( $this->input->post() ){
			$this->session->set_userdata( 'app_data-'.$this->input->post('cat'), $this->input->post() );

			if( ($step+1) > count( $cat ) )
				$this->save_feedback();
		}

		$_questions = array();
		$sub_cat = $this->appraisal_model->getAppraisalSubCategories( array( 'main_cat_id' => $cat[$step]['main_category_id'] ) );
		foreach ($sub_cat as $sc) {
			$q_param = array( 
								'appraisal_id'	=> $app_id
								,'category'		=> $cat[$step]['main_category_id']
								,'sub_category' => $sc['sub_category_id']
							);

			$questions = $this->appraisal_model->getFeedbackQuestion( $q_param );
			if( count( $questions ) > 0 ) {
				foreach ($questions as $question) {
					$_questions[ $sc['sub_category_name'] ][] = $question;
				}
			}
		}

		if( empty($_questions) ){
			$template_param['invalid']	= array(
													'str' => '<i class="icon-ban-circle"></i> Feedback question not found! ' . anchor( base_url().'feedbacks', '<i class="icon-chevron-left"></i> back' )
													,'class' => 'warning'
												);
		}

		$template_param['header']		= ucwords( $cat[$step]['main_category_name'] );
		$template_param['questions']	= $_questions;
		$template_param['step']			= $step + 1;
		$template_param['cat']			= $cat[$step]['main_category_id'];

		$template_param['content']		 = 'feedback_questions';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function save_feedback() {
		$app_id		= $this->uri->segment( 3 );
		$assign_id	= $this->uri->segment( 4 );
		$q_param	= array();
		$where		= array();
		$feed_type	= $this->uri->segment( 2 );

		switch ( $feed_type ) {
			case 'self_feedback':
				$field		= 'self_score';
				$u_field	= 'user_id';
				$table 		= APP_ASSIGN;
				$log 		= 'Evaluate self appraisal';
				break;

			case 'peer_feedback':
				$field		= 'peer_score';
				$u_field	= 'peer_id';
				$table 		= APP_PEER_ASSIGN;
				$log 		= 'Evaluate peer appraisal';
				break;
			
			default:
				$field		= 'manager_score';
				$u_field	= 'manager_id';
				$table 		= APP_MNGR_ASSIGN;
				$log 		= 'Evaluate employee appraisal';
				break;
		}

		$cat = $this->appraisal_model->getAppraisalMainCategories();
		foreach ($cat as $c) {			
			foreach ( $this->session->userdata('app_data-'.$c['main_category_id']) as $key => $value ) {
				if( preg_match('/question/', $key) ) {
					$q_id = explode( '_', $key );
					
					if( $feed_type == 'self_feedback' ){
						$q_param = array(
											$u_field => $this->session->userdata('user_id')
											,'appraisal_id' => $app_id
											,'question_id' => $q_id[1]
											,$field => $value
										);
					}else{
						$assign_user = $this->appraisal_model->getAssignedEmployee( $assign_id, $app_id );
						$q_param = array(
											$field 			=> $value
											,$u_field		=> $this->session->userdata('user_id')
											,'user_id'		=> $assign_user[0]['user_id']
											,'appraisal_id' => $app_id
											,'question_id'	=> $q_id[1]
										);
					}

					$this->appraisal_model->insertFeedbackForm( $q_param );
				}
			}
		}		

		$up_stats = array(
							$u_field => $this->session->userdata('user_id')
							,'app_id' => $app_id
						 );

		$this->appraisal_model->updateFeedbackStatus( $up_stats, $table );

		$log = array( 
						'user_id'	=> $this->session->userdata( 'user_id' )
						,'history'	=> $log
					);
		$this->template_library->insert_log( $log );

		redirect( base_url().'feedbacks/thank_you' );
	}

	public function thank_you() {
		$template_param['header']		= 'Done!';

		$template_param['content']		 = 'feedback_questions';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function get_feedback_summary() {
		if ($this->input->is_ajax_request() ){
			$cat = $this->input->post( 'cat' );

			$result = 'print';
		}
		switch ( $cat ) {
			case 'self':
				$field = 'self_score';
				$user = 'user_id';
				break;

			case 'peer':
				$field = 'peer_score';
				$user = 'peer_id';
				break;
			
			default:
				$field = 'manager_score';
				$user = 'manager_id';
				break;
		}

		if( isset( $result ) ){
			$result_param = array(
									$user				=> $this->session->userdata( 'user_id' )
									,'aq.appraisal_id'	=> $this->input->post( 'app_id' )
								 );

			$main_cat = $this->appraisal_model->getFeedbackSummary( $field, $result_param );
			foreach ($main_cat as $mc) {
				$where = array_merge( $result_param, array( 'main_cat_id' => $mc['main_category_id'] ) );
				$sub_cat = $this->appraisal_model->getFeedbackSummarySubCat( $field, $where );
				foreach ($sub_cat as $sc) {
					$data['summary'][ $mc['main_category_name'] ][ $mc['ave'] ][] = $sc;
				}
			}
			echo $this->load->view( 'templates/appraisal_summary', $data, true );
		}
		else
			return $this->appraisal_model->getFeedbackSummary( $field );
	}

}

/* End of file feedbacks.php */
/* Location: ./application/controllers/feedbacks.php */