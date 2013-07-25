<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Appraisal_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllAppraisal( $offset, $per_page, $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db
                        ->limit( $per_page, $offset )
                        ->get( APPRAISAL )
                        ->result_array();

    }

    public function getTotalAppraisal( $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db->count_all_results( APPRAISAL );
    }

    public function saveNewAppraisal( $db_param ) {
        $this->db->insert( APPRAISAL, $db_param );
        return $this->db->insert_id();
    }

    public function updateAppraisal( $db_param ) {
        $param = array();
        foreach ($db_param as $key => $value) {
            if( $key != 'activity_id' ){
                $param[ $key ] = $value;
            }
        }
        
        return $this->db
                        ->where( 'activity_id', $db_param[ 'activity_id' ] )
                        ->update( APPRAISAL, $param );
    }

    public function deleteAppraisal( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( APPRAISAL );

        return true;
    }
    
}