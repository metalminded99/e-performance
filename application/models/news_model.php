<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getActiveNews( ){
        return $this->db
                        ->where( array( 'active' => 1 ) )
                        ->get( NEWS )
                        ->result_array();
    }

}