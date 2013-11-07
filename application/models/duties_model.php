<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Duties_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllDuties( $offset, $per_page, $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );
        
        return $this->db
                        ->limit( $per_page, $offset )
                        ->get( DUTIES )
                        ->result_array();

    }    
    
    public function getAllJobDuties( $offset, $per_page, $where = null ) {
        $this->db
                ->select( 'D.duty_id, D.duty_code, D.duty_name, D.duty_desc, JD.job_id, JD.active' )
                ->from( JOB_DUTIES.' JD' )
                ->join( DUTIES.' D', 'D.duty_id = JD.duty_id' ,'LEFT' );
        
        if( !is_null( $where ) )
            $this->db->where( $where );

        $this->db
                ->limit( $per_page, $offset )
                ->order_by( 'D.duty_name', 'ASC' );

        return $this->db
                        ->get()
                        ->result_array();

    }

    public function getTotalDuties( $table, $param = null ) {
        if( is_null( $param ) ) {
            return $this->db
                            ->count_all_results( $table );
        }else{
            return $this->db
                            ->where( $param )
                            ->count_all_results( $table );
        }
    }

    public function saveNewJobDuty( $db_param ) {
        $this->db->insert( JOB_DUTIES, $db_param );
        return $this->db->insert_id();
    }

    public function updateJobDuty( $db_param, $where ) {
        return $this->db
                        ->where( $where )
                        ->update( JOB_DUTIES, $db_param );
    }

    public function saveNewDuty( $db_param ) {
        $this->db->insert( DUTIES, $db_param );
        return $this->db->insert_id();
    }

    public function updateDuty( $db_param ) {
        $param = array();
        foreach ($db_param as $key => $value) {
            if( $key != 'duty_id' ){
                $param[ $key ] = $value;
            }
        }
        
        return $this->db
                        ->where( 'duty_id', $db_param[ 'duty_id' ] )
                        ->update( DUTIES, $param );
    }

    public function deleteDuty( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( DUTIES );

        return true;
    }

    public function deleteJobDuty( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( JOB_DUTIES );

        return true;
    }
    
}