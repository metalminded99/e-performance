<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_library {
	protected $CI;
	protected $CI_load;

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI_load = $this->CI->load;
	}

	public function do_upload( $folder, $filename ) {
		$config['upload_path']	= './uploads/'.$folder;
		$config['file_name']	= $filename;
		$config['allowed_types']= 'gif|jpg|png|jpeg';
		$config['overwrite']	= TRUE;
		$config['max_size']		= '2048';
		$config['max_width']	= '0';
		$config['max_height']	= '0';

		$this->CI_load->library('upload', $config);
		if ( !$this->CI->upload->do_upload( 'avatar' ) ) {
			$return = array( 'error' => $this->CI->upload->display_errors('<span>', '</span>') );
		}
		else {
			$return = array( 'upload_data' => $this->CI->upload->data() );
		}

		return $return;
	}

}

/* End of file template_library.php */
/* Location: ./application/libraries/template_library.php */
