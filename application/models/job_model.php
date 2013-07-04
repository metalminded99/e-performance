<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Job_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllJob( $offset, $per_page, $dept = null, $db_param = null ) {
        if( !is_null($dept) ) {
            $this->db->select( 'job_id, job_title' );
            return $this->db
                            ->where( array( 'dept_id' => $dept ) )
                            ->get( JOBS )
                            ->result();
        } else {
            $this->db
                    ->select( 'j.job_id, j.dept_id, j.job_title, j.job_desc, d.dept_name' )
                    ->from( JOBS.' j' )
                    ->join( DEPT.' d', 'd.dept_id = j.dept_id', 'left' )
                    ->limit( $per_page, $offset );
            if( !is_null( $db_param ) )
                $this->db->where( $db_param ); 
            
            return $this->db->get()->result_array();
        }
    }

    public function getTotalJob( $dept = null ) {
    	return $this->db->count_all( JOBS );
    }

    public function saveNewJob( $db_param ) {
        $this->db->insert( JOBS, $db_param );
        return $this->db->insert_id();
    }

    public function updateJob( $db_param ) {
        $param = array();
        foreach ($db_param as $key => $value) {
            if( $key != 'job_id' ){
                $param[ $key ] = $value;
            }
        }
        
        return $this->db
                        ->where( 'job_id', $db_param[ 'job_id' ] )
                        ->update( JOBS, $param );
    }

    public function deleteJob( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( JOBS );

        return true;
    }

    public function getJobStats() {
        return $this->db
                        ->select( 'count(*) total' )
                        ->from( JOBS )
                        ->get()
                        ->result_array();
    }
}
