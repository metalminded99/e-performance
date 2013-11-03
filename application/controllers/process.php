<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Process extends CI_Controller {

	protected $user_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'process_model' );

		$this->user_id = $this->session->userdata( 'user_id' );
	}

	public function index() {
		$this->lists();
	}

	public function lists( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Process list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'process/lists' 
																					,$this->process_model->getTotalEmpProcess( 
																																array( 
																																		'user_id' => $this->user_id 
																																		, 'status' => 'Pending'
																																	) 
																															)
																					,PER_PAGE
																					,'user'
																					,$offset
																				);
		$template_param['process'] = $this->process_model->getAllEmpProcess( $offset, PER_PAGE, array( 'user_id' => $this->user_id, 'status' => 'Pending' ) );
		# Template meta data
		$template_param['count'] = $offset;
		$template_param['uri'] = '';
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

	public function on_going( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Process list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'process/on_going' 
																					,$this->process_model->getTotalEmpProcess( array( 'user_id' => $this->user_id, 'status' => 'On-going' ) )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);
		$template_param['process'] = $this->process_model->getAllEmpProcess( $offset, PER_PAGE, array( 'user_id' => $this->user_id, 'status' => 'On-going' ) );
		# Template meta data
		$template_param['count'] = $offset;
		$template_param['uri'] = 'on_going';
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

	public function completed( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Process list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'process/completed' 
																					,$this->process_model->getTotalEmpProcess( array( 'user_id' => $this->user_id, 'status' => 'Completed' ) )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);
		$template_param['process'] = $this->process_model->getAllEmpProcess( $offset, PER_PAGE, array( 'user_id' => $this->user_id, 'status' => 'Completed' ) );
		# Template meta data
		$template_param['count'] = $offset;
		$template_param['uri'] = 'completed';
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

	public function rejected( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Process list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'process/rejected' 
																					,$this->process_model->getTotalEmpProcess( array( 'user_id' => $this->user_id, 'status' => 'Rejected' ) )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);
		$template_param['process'] = $this->process_model->getAllEmpProcess( $offset, PER_PAGE, array( 'user_id' => $this->user_id, 'status' => 'Rejected' ) );
		# Template meta data
		$template_param['count'] = $offset;
		$template_param['uri'] = 'rejected';
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

	public function ajax_request() {
		if( $this->input->is_ajax_request() ){
			$date = date('Y-m-d h:i:s');
			if( $this->input->post('action') == 'start' ) {
				$up = array( 
								 'status'		=> 'On-going'
								,'date_start'	=> $date
							);
				$msg = 'Process is now on-going.';
			}

			if( $this->input->post('action') == 'complete' ) {
				$up = array( 
								 'status'				=> 'Completed'
								,'date_accomplished'	=> $date
							);
				$msg = 'Process is now completed.';
			}

			if( $this->input->post('action') == 'reject' ) {
				$up = array( 
								 'status' 			=> 'Rejected'
								,'date_rejected'	=> $date
							);
				$comment = array( 'comment' => $this->input->post('msg') );
				$msg = 'Process rejected.';
			}

			if( $this->input->post('action') == 'get_comment' ) {
				$comments = $this->process_model->getEmpProcessComment( $this->input->post('proc_id'), $this->session->userdata('user_id') );
				echo json_encode($comments[0]);
				return true;
			}

			if( isset( $up ) ){
				$this->process_model->updateEmpProcess( $this->input->post('proc_id'), $this->session->userdata('user_id'), $up );
				if( isset($comment) )
					$this->process_model->insertEmpProcessComment( 
																	array_merge( 
																					 array( 'proc_id' => $this->input->post('proc_id') )
																					,array( 'user_id' => $this->session->userdata('user_id') )
																					,$comment
																					,$up 
																				) 
																 );

				$this->session->set_flashdata( 'msg', $msg );
			}
			echo true;
		}else
			redirect( base_url() );
	}

}

/* End of file process.php */
/* Location: ./application/controllers/process.php */