<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Process extends CI_Controller {

	protected $user_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'process_model' );

		$this->user_id = $this->session->userdata( 'user_id' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Process list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'Process' 
																					,$this->process_model->getTotalEmpProcess( array( 'user_id' => $this->user_id ) )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);
		$template_param['process'] = $this->process_model->getAllEmpProcess( $offset, PER_PAGE, array( 'user_id' => $this->user_id ) );
		# Template meta data
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'employee_process';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

}

/* End of file process.php */
/* Location: ./application/controllers/process.php */