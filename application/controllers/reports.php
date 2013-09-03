<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model( 'appraisal_model' );

		$this->user_job_id = $this->session->userdata( 'job_id' );
	}

	public function index(){
		redirec( base_url().'reports/dept_goals' );
	}

	public function dept_goals() {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Template meta data
		$data['active']						= 'dgoals';
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

	public function emp_goals() {
		# Check user's session
		$this->template_library->check_session( 'user' );

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

		# Template meta data
		$data['active']						= 'plan';
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

	public function process() {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Template meta data
		$data['active']						= 'proc';
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

}

/* End of file appraisal.php */
/* Location: ./application/controllers/appraisal.php */