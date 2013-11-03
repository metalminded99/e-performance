<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Goal_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllEmpGoal( $offset, $per_page, $where = array() ) {
            $this->db
                    ->select( 'eg.*, dg.goal_id dg_id, dg.goal_title dg_title' )
                    ->from( EMP_GOALS. ' eg' )
                    ->join( DEPT_GOALS. ' dg', 'dg.department_id = eg.dept_goal_id', 'left' )
                    ->order_by( 'eg.due_date', 'ASC' )
                    ->limit( $per_page, $offset );
            
            if( !is_null( $where ) )
                $this->db->where( $where ); 
            
            return $this->db
                            ->get()
                            ->result_array();
    }

    public function getTotalEmpGoal( $user_id, $status = null ) {
        if( !is_null( $status ) )
            $this->db->where( array( 'status' => $status ) );

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
            if( $db_param[ 'status' ] == 'Pending' ){
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
            }   else {
                $this->db
                         ->where( $where )
                         ->update( EMP_GOALS , $db_param );
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

    public function addEmpGoalComment( $db_param ) {
        $this->db->insert( EMP_GOALS_COM, $db_param );
    }

    public function deleteEmpGoal( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( EMP_GOALS );

        return true;
    }

    public function getGoalStats() {
        return $this->db
                        ->select( 'count(*) total' )
                        ->from( JOBS )
                        ->get()
                        ->result_array();
    }

    public function getEmpGoalReminder( $user_id ) {
        $where = array( 
                        'user_id' => $user_id
                        ,'status' => 'Not Started'
                      );
        #"DATE_FORMAT(DATE_SUB(DUE_DATE, INTERVAL days_to_remind DAY), '%Y-%m-%d') = LEFT(SYSDATE(),10)" => null
        return $this->db
                        ->where( $where )
                        ->count_all_results( EMP_GOALS );
    }

    public function getAllDeptGoal( $offset, $per_page, $where = array() ) {
            $this->db
                    ->from( DEPT_GOALS )
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
                        ->where( array( 'department_id' => $dept ) )
                        ->count_all_results( DEPT_GOALS );
    }

    public function saveNewDeptGoal( $db_param ) {
        $this->db->insert( DEPT_GOALS, $db_param );
        return $this->db->insert_id();
    }

    public function updateDeptGoal( $goal_id, $db_param ) {
        $where = array( 'goal_id' => $goal_id );

        return $this->db
                        ->where( $where )
                        ->update( DEPT_GOALS, $db_param );
    }

    public function deleteDeptGoal( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( DEPT_GOALS );

        return true;
    }

    public function getEmpGoalReport( $where, $by, $order = 'ASC' ) {
        return $this->db
                        ->select( "CONCAT(u.fname, ' ', u.lname)  full_name, eg.goal_title, eg.goal_desc, DATE_FORMAT(eg.due_date,'%b %d, %Y') due, eg.percentage, DATE_FORMAT(eg.date_approved,'%b %d, %Y') approved, eg.status", FALSE )
                        ->from( EMP_GOALS.' eg' )
                        ->join( USER.' u', 'u.user_id = eg.user_id', 'left' )
                        ->where( $where )
                        ->order_by( $by, $order )
                        ->get()
                        ->result_array();
    }

    public function getEmpGoalComment( $where ) {
        return $this->db
                        ->where( $where )
                        ->get( EMP_GOALS_COM )
                        ->result_array();
    }

}
