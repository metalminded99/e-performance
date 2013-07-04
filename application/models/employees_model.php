<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Employees_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllEmployees( $offset, $per_page, $where = array() ) {
        return $this->db
                        ->select( 'U.*, J.job_title, J.job_desc, D.dept_name, D.dept_desc' )
                        ->from( USER.' U' )
                        ->join( JOBS.' J', 'J.job_id = U.job_id', 'left' )
                        ->join( DEPT.' D', 'D.dept_id = U.department_id', 'left' )
                        ->limit( $per_page, $offset )
                        ->where( $where )
                        ->get()
                        ->result_array();

    }    
    
    public function getAllJobEmployees( $offset, $per_page, $where = null ) {
        $this->db
                ->select( 'S.skill_id, S.skill_code, S.skill_name, S.skill_desc, JS.job_id, JS.active' )
                ->from( JOB_SKILLS.' JS' )
                ->join( SKILLS.' S', 'S.skill_id = JS.skill_id' ,'LEFT' );
        
        if( !is_null( $where ) )
            $this->db->where( $where );

        $this->db
                ->limit( $per_page, $offset )
                ->order_by( 'S.skill_name', 'ASC' );

        return $this->db
                        ->get()
                        ->result_array();

    }

    public function getTotalEmployees( $param = null ) {
    	return $this->db
                        ->where( $param )
                        ->count_all_results( USER );
    }

    public function saveNewJobSkill( $db_param ) {
        $this->db->insert( JOB_SKILLS, $db_param );
        return $this->db->insert_id();
    }

    public function updateJobSkill( $db_param, $where ) {
        return $this->db
                        ->where( $where )
                        ->update( JOB_SKILLS, $db_param );
    }

    public function saveNewSkill( $db_param ) {
        $this->db->insert( SKILLS, $db_param );
        return $this->db->insert_id();
    }

    public function updateSkill( $db_param ) {
        $param = array();
        foreach ($db_param as $key => $value) {
            if( $key != 'skill_id' ){
                $param[ $key ] = $value;
            }
        }
        
        return $this->db
                        ->where( 'skill_id', $db_param[ 'skill_id' ] )
                        ->update( SKILLS, $param );
    }

    public function deleteSkill( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( SKILLS );

        return true;
    }

    public function deleteJobSkill( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( JOB_SKILLS );

        return true;
    }
    
}