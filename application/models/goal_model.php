<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Goal_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllEmpGoal( $offset, $per_page, $where = array(), $fld = 'goal_id, goal_title, goal_desc, due_date, date_created, status' ) {
            $this->db
                    ->select( $fld )
                    ->from( EMP_GOALS )
                    ->order_by( 'due_date', 'ASC' )
                    ->limit( $per_page, $offset );
            
            if( !is_null( $where ) )
                $this->db->where( $where ); 
            
            return $this->db
                            ->get()
                            ->result_array();
    }

    public function getTotalDeptGoal( $dept ) {
        return $this->db
                        ->where( array( 'dept_id' => $dept ) )
                        ->count_all_results( DEPT_GOALS );
    }

    public function getTotalEmpGoal( $user_id ) {
    	return $this->db
                        ->where( array( 'user_id' => $user_id ) )
                        ->count_all_results( EMP_GOALS );
    }

    public function saveNewEmpGoal( $db_param ) {
        $this->db->insert( EMP_GOALS, $db_param );
        return $this->db->insert_id();
    }

    public function updateEmpGoal( $goal_id, $db_param ) {
        $where = array( 'goal_id' => $goal_id );
        if( isset( $db_param[ 'status' ] ) ) {
            if( $db_param[ 'status' ] == 'Not Started' ){
                $now = date('Y-m-d h:i:s');
                $this->db
                         ->where( $where )
                         ->update( 
                                    EMP_GOALS
                                    ,array( 
                                            'approved' => 1
                                            ,'date_approved' => $now
                                          ) 
                                 );
            }
        }

        if( isset( $db_param[ 'percentage' ] ) ) {
            if( $db_param[ 'percentage' ] > 0 ){
                $this->db
                         ->where( $where )
                         ->update( 
                                    EMP_GOALS
                                    ,array( 
                                            'status' => 'In Progress'
                                          )
                                 );
            }
        }

        return $this->db
                        ->where( $where )
                        ->update( EMP_GOALS, $db_param );
    }

    public function deleteEmpGoal( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( EMP_GOALS );

        return true;
    }

    public function deleteGoal( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( JOBS );

        return true;
    }

    public function getGoalStats() {
        return $this->db
                        ->select( 'count(*) total' )
                        ->from( JOBS )
                        ->get()
                        ->result_array();
    }
}
