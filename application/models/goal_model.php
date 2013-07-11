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
                        ,"DATE_FORMAT(DATE_SUB(DUE_DATE, INTERVAL days_to_remind DAY), '%Y-%m-%d') = LEFT(SYSDATE(),10)" => null
                      );

        return $this->db
                        ->where( $where )
                        ->count_all_results( EMP_GOALS );
    }

    public function getAllDeptGoal( $offset, $per_page, $where = array(), $fld = 'goal_id, goal_title, goal_desc, due_date, date_created' ) {
            $this->db
                    ->select( $fld )
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

}
