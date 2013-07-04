<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class History_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getUserLogs( $user_id ){
        return $this->db
                        ->where( array( 'user_id' => $user_id ) )
                        ->get( HISTORY )
                        ->result_array();
    }

}