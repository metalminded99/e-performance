<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template_library {
	protected $CI;
	protected $CI_load;

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI_load = $this->CI->load;
	}

	public function render( $params = array(), $head = 'header', $top = 'top', $foot = 'footer', $nav = 'nav' ) {
		if(empty($params)) exit("Ooops! There's something wrong in the system.");

		$this->CI_load->view( COMPONENTS.$head, $params );
		$this->CI_load->view( COMPONENTS.$top, $params );
		if( $nav != '' )
			$this->CI_load->view( COMPONENTS.$nav, $params );
		$this->CI_load->view( $params['content'], $params );
		$this->CI_load->view( COMPONENTS.$foot, $params );
	}

	public function check_session( $page = 'admin' ){
		if( $page == 'admin' ) {
			if( !$this->CI->session->userdata( 'control_panel' ) )
				redirect( base_url().'admin/login' );
		}elseif( $page == 'user' ) {
			if( !$this->CI->session->userdata( 'user' ) )
				redirect( base_url() );
		}

		return false;
	}

	public function clear_cache() {
 		$this->CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->CI->output->set_header("Pragma: no-cache");
	}

	function get_pagination( $uri, $total_rows, $module = 'admin', $offset = 0 ) {
		$this->CI_load->library( 'pagination' );

		$config['base_url'] = base_url() . $uri;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = PER_PAGE;
		if( $module == 'admin' ){			
			$config['full_tag_open'] = '<div class="pagination">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = '« First';
			$config['first_tag_open'] = '<span>';
			$config['first_tag_close'] = '</span>';
			$config['last_link'] = 'Last »';
			$config['last_tag_open'] = '<span>';
			$config['last_tag_close'] = '</span>';
			$config['cur_tag_open'] = '<span class="active">';
			$config['cur_tag_close'] = '</span>';
		}else{
			$config['offset'] 			= $offset;
			$config['uri_segment'] 		= 2;

			$config['cur_tag_open'] 	= '<li class="active"><a href="#">';
			$config['cur_tag_close'] 	= '</a></li>';
			$config['prev_link'] 		= 'Prev';
			$config['prev_tag_open'] 	= '<li>';
			$config['prev_tag_close'] 	= '</li>';
			$config['next_link'] 		= 'Next';
			$config['next_tag_open'] 	= '<li>';
			$config['next_tag_close'] 	= '</li>';
			$config['num_tag_open'] 	= '<li>';
			$config['num_tag_close'] 	= '</li>';
		}

		$this->CI->pagination->initialize($config);
		return $this->CI->pagination->create_links();
	}

	public function check_image_exist( $img_url, $no_image ) {
		$img_header = @get_headers( $img_url );
		$http_header = explode(" ", $img_header[0]);
		
		$codes = array( '404', '403' );
		if( in_array($http_header[1], $codes) ){
			return $no_image;
		}

		return $img_url;
	}

	public function shorten_words( $str, $limit = 5 ) {
		$words = explode( ' ', $str );
		if( count($words) > $limit ){
			return implode( " ", array_splice( $words,0,$limit ) ) . "...";
		}

		return $str;
	}

	public function format_mysql_date( $mysql_date, $format ) {
		$datetime = strtotime( $mysql_date );
		return date( $format, $datetime );
	}

	public function get_year_diff( $date1, $date2 ){
		$date_diff=strtotime($date2)-strtotime($date1);
		return floor( ( $date_diff )/ ( 60 * 60 * 24 * 365 ) );
	}

	public function date_add( $date, $num, $format = 'Y-m-d' ){
		$date = new DateTime( $date );
		$date->add(new DateInterval('P'.$num.'D'));
		return $date->format( $format );
	}

	public function check_array_value_exist( $array, $to_search ) {
		if( count( $array ) > 0 ){
			for ($i=0; $i < count( $array ); $i++) { 
				if( array_search( $to_search, $array[$i] ) ){
					return true;
				}
			}
			
			return false;
		}else{
			return false;
		}
	}

	public function insert_log( $logs ) {
		$this->CI_load->model( 'history_model' );

		$this->CI->history_model->insert_log( $logs );
	}

}

/* End of file template_library.php */
/* Location: ./application/libraries/template_library.php */
