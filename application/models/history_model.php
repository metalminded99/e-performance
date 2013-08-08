<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class History_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function getUserLogs( $user_id, $limit = 5 ){
        return $this->db
                        ->where( array( 'user_id' => $user_id ) )
                        ->order_by( 'date_done', 'desc' )
                        ->limit( $limit, 0 )
                        ->get( HISTORY )
                        ->result_array();
    }
    
    public function insert_log( $log_data ){
        return $this->db->insert( HISTORY, $log_data );
    }

}