<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedbacks extends CI_Controller {
	protected $user_id;
	protected $category;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'appraisal_model' );

		$this->user_id = $this->session->userdata( 'user_id' );
		$this->category = array(
									'core'
									,'perf'
									,'skills'
									,'abl'
								);
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

	public function feedback_question( $cat, $app_id, $assign = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		if( $this->input->post() )
			$this->save_feedback();

		$q_param = array( 
							'appraisal_id'	=> $app_id
							,'category'		=> $cat
						);

		$questions = $this->appraisal_model->getFeedbackQuestion( $q_param );
		if( !$questions ){
			$template_param['invalid']	= array(
													'str' => '<i class="icon-ban-circle"></i> Feedback question not found! ' . anchor( base_url().'feedbacks', '<i class="icon-chevron-left"></i> back' )
													,'class' => 'warning'
												);
		}

		switch ( $cat ) {
			case 'core':
				$header = 'Core Competencies';
				break;

			case 'perf':
				$header = 'Performance Output';
				break;

			case 'skills':
				$header = 'Skills';
				break;
			
			default:
				$header = 'Abilities';
				break;
		}

		$template_param['header']		= $header;
		$template_param['questions']	= $questions;

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
		$cat_index	= array_search($this->uri->segment( 3 ), $this->category);
		$app_id		= $this->uri->segment( 4 );
		$assign_id	= $this->uri->segment( 5 );
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

		foreach ( $this->input->post() as $key => $value ) {
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
		
		if( isset( $this->category[ $cat_index + 1 ] ) ){
			if( $assign_id != '' )
				redirect( base_url().'feedbacks/'.$feed_type.'/'.$this->category[ $cat_index + 1 ].'/'.$app_id.'/'.$assign_id );
			else
				redirect( base_url().'feedbacks/'.$feed_type.'/'.$this->category[ $cat_index + 1 ].'/'.$app_id );
		}
		else{
			if( $u_field != 'user_id' ){
				$up_stats = array(
									$u_field => $this->session->userdata('user_id')
								 );
			}else{
				$up_stats = array(
									$u_field => $this->session->userdata('user_id')
									,'app_id' => $app_id
								 );
			}

			$this->appraisal_model->updateFeedbackStatus( $up_stats, $table );

			$log = array( 
							'user_id'	=> $this->session->userdata( 'user_id' )
							,'history'	=> $log
						);
			$this->template_library->insert_log( $log );

			redirect( base_url().'feedbacks/thank_you' );
		}
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
			echo json_encode( $this->appraisal_model->getFeedbackSummary( $field, $result_param ) );
		}
		else
			return $this->appraisal_model->getFeedbackSummary( $field );
	}

}

/* End of file feedbacks.php */
/* Location: ./application/controllers/feedbacks.php */