<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllNews( $offset, $per_page, $where = null ){
        if( !is_null( $where ) )
            $this->db->where( $where );
        
        return $this->db
                        ->get( NEWS )
                        ->result_array();
    }

}