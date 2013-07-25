<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Not_found extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->library( 'user_agent' );
	}

	public function index() {
		$this->load->view( '404' );
	}

}

/* End of file not_found.php */
/* Location: ./application/controllers/not_found.php */