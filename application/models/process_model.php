<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Process_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllProcess( $offset, $per_page, $where = array() ) {
            $this->db
                    ->select( '*' )
                    ->from( PROCESS )
                    ->order_by( 'date_added', 'DESC' )
                    ->limit( $per_page, $offset );
            
            if( !is_null( $where ) )
                $this->db->where( $where ); 
            
            return $this->db
                            ->get()
                            ->result_array();
    }

    public function getTotalProcess() ) {
    	return $this->db
                        ->count_all_results( PROCESS );
    }

    public function saveNewProcess( $db_param ) {
        $this->db->insert( PROCESS, $db_param );
        return $this->db->insert_id();
    }

    public function updateProcess( $goal_id, $db_param ) {
        $where = array( 'goal_id' => $goal_id );
        if( isset( $db_param[ 'status' ] ) ) {
            if( $db_param[ 'status' ] == 'Not Started' ){
                $now = date('Y-m-d h:i:s');
                $this->db
                         ->where( $where )
                         ->update( 
                                    PROCESS
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
                                    PROCESS
                                    ,array( 
                                            'status' => 'In Progress'
                                          )
                                 );
            }
        }

        return $this->db
                        ->where( $where )
                        ->update( PROCESS, $db_param );
    }

    public function deleteProcess( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( PROCESS );

        return true;
    }

    public function getProcessReminder( $user_id ) {
        $where = array( 
                        'user_id' => $user_id
                        ,"DATE_FORMAT(DATE_SUB(DUE_DATE, INTERVAL days_to_remind DAY), '%Y-%m-%d') = LEFT(SYSDATE(),10)" => null
                      );

        return $this->db
                        ->where( $where )
                        ->count_all_results( PROCESS );
    }

}
