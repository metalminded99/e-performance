<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Appraisal_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllAppraisal( $offset, $per_page, $where = null ) {
        return $this->db
                        ->limit( $per_page, $offset )
                        ->get( APPRAISAL )
                        ->result_array();

    }    
    
    public function getAllJobAppraisal( $offset, $per_page, $where = null ) {
        $this->db
                ->select( 'A.activity_id, A.activity_code, A.activity_name, A.activity_desc, JA.job_id, JA.active' )
                ->from( APPRAISAL.' JA' )
                ->join( APPRAISAL.' A', 'A.activity_id = JA.activity_id' ,'LEFT' );
        
        if( !is_null( $where ) )
            $this->db->where( $where );

        $this->db
                ->limit( $per_page, $offset )
                ->order_by( 'A.activity_name', 'ASC' );

        return $this->db
                        ->get()
                        ->result_array();

    }

    public function getTotalAppraisal( $table, $param = null ) {
        if( is_null( $param ) ) {
            return $this->db
                            ->count_all_results( $table );
        }else{
            return $this->db
                            ->where( $param )
                            ->count_all_results( $table );
        }
    }

    public function saveNewJobActivity( $db_param ) {
        $this->db->insert( APPRAISAL, $db_param );
        return $this->db->insert_id();
    }

    public function updateJobActivity( $db_param, $where ) {
        return $this->db
                        ->where( $where )
                        ->update( APPRAISAL, $db_param );
    }

    public function saveNewActivity( $db_param ) {
        $this->db->insert( APPRAISAL, $db_param );
        return $this->db->insert_id();
    }

    public function updateActivity( $db_param ) {
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

    public function deleteActivity( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( APPRAISAL );

        return true;
    }

    public function deleteJobActivity( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( APPRAISAL );

        return true;
    }
    
}