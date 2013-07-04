<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Activities_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllActivities( $offset, $per_page, $where = null ) {
        return $this->db
                        ->limit( $per_page, $offset )
                        ->get( ACTIVITIES )
                        ->result_array();

    }    
    
    public function getAllJobActivities( $offset, $per_page, $where = null ) {
        $this->db
                ->select( 'A.activity_id, A.activity_code, A.activity_name, A.activity_desc, JA.job_id, JA.active' )
                ->from( JOB_ACTIVITIES.' JA' )
                ->join( ACTIVITIES.' A', 'A.activity_id = JA.activity_id' ,'LEFT' );
        
        if( !is_null( $where ) )
            $this->db->where( $where );

        $this->db
                ->limit( $per_page, $offset )
                ->order_by( 'A.activity_name', 'ASC' );

        return $this->db
                        ->get()
                        ->result_array();

    }

    public function getTotalActivities( $table, $param = null ) {
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
        $this->db->insert( JOB_ACTIVITIES, $db_param );
        return $this->db->insert_id();
    }

    public function updateJobActivity( $db_param, $where ) {
        return $this->db
                        ->where( $where )
                        ->update( JOB_ACTIVITIES, $db_param );
    }

    public function saveNewActivity( $db_param ) {
        $this->db->insert( ACTIVITIES, $db_param );
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
                        ->update( ACTIVITIES, $param );
    }

    public function deleteActivity( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( ACTIVITIES );

        return true;
    }

    public function deleteJobActivity( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( JOB_ACTIVITIES );

        return true;
    }
    
}