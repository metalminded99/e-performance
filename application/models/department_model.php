<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Department_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllDepartment( $offset, $per_page, $where = null ) {
        if( !is_null( $where ) ){
            $this->db
                    ->where( $where )
                    ->limit( 1 );
        }else
            $this->db->limit( $per_page, $offset );

        return $this->db->get( DEPT )->result_array();

    }

    public function getTotalDepartment() {
    	return $this->db->count_all( DEPT );
    }

    public function saveNewDepartment( $db_param ) {
        $this->db->insert( DEPT, $db_param );
        return $this->db->insert_id();
    }

    public function updateDepartment( $db_param ) {
        $param = array();
        foreach ($db_param as $key => $value) {
            if( $key != 'dept_id' ){
                $param[ $key ] = $value;
            }
        }
        
        return $this->db
                        ->where( 'dept_id', $db_param[ 'dept_id' ] )
                        ->update( DEPT, $param );
    }

    public function deleteDepartment( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( DEPT );

        return true;
    }

    public function getDeptStats() {
        return $this->db
                        ->select( 'count(*) total' )
                        ->from( DEPT )
                        ->get()
                        ->result_array();
    }
    
}