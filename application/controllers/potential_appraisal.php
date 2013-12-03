<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Potential_appraisal extends CI_Controller {
	protected $user_id;
	protected $user_job_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'potential_appraisal_model' );

		$this->user_id = $this->session->userdata( 'user_id' );
		$this->user_job_id = $this->session->userdata( 'job_id' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Appraisal list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'potential_appraisal/index' 
																					,$this->potential_appraisal_model->getTotalPotentialAppraisal( array('manager_id' => $this->user_id) )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);

		$template_param['potentials'] = $this->potential_appraisal_model->getAllPotentialAppraisal( $offset, PER_PAGE, array('manager_id' => $this->user_id) );
		# Template meta data
		$template_param['counter']	= $offset;

		$template_param['left_side_nav'] = $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']		 = 'potential_appraisal';
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
		$this->load->model('potential_appraisal_model');
		$this->load->model('employees_model');
		# Appraisal list
		if( $this->input->post() )
			$this->save('add');

		$where = array( 
						'U.job_id' => $this->user_job_id
						,'U.lvl ' => 3 
					  );
		$template_param['employees'] = $this->employees_model->getAllEmployees( 
																				0
																				,10000
																				,$where
																			  );
		$template_param['questions'] = $this->potential_appraisal_model->getPotentialAppraisalQuestion( );

		# Template meta data
		$template_param['left_side_nav'] = $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']		 = 'add_potential_appraisal';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function save( $action ) {
		if( $action == 'add' ){
			$req = $this->input->post();
			$db_param = array();
			$_param = array(
								'user_id'		=> $this->input->post('employee')
								,'manager_id'	=> $this->session->userdata('user_id')
							);
			foreach ($req as $key => $val) {
				if( preg_match('/question/', $key) ){
					$_q = explode('_', $key);
					$db_param[] = array_merge( $_param, array( 'question_id' => end($_q), 'manager_score' => $val ) );
				}
			}
			$this->potential_appraisal_model->addPotentialAppraisal( $db_param );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> New potential appraisal has been added successfully!', 'class' => 'info' ) );
		}

		redirect( base_url().'potential_appraisal' );
	}

}

/* End of file feedbacks.php */
/* Location: ./application/controllers/feedbacks.php */