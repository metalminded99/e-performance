<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Process_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllProcess( $offset, $per_page, $where = array() ) {
            $this->db
                    ->select( 'proc_id, proc_title, proc_desc, start_date, end_date' )
                    ->from( PROCESS )
                    ->order_by( 'date_added', 'DESC' )
                    ->limit( $per_page, $offset );
            
            if( !is_null( $where ) )
                $this->db->where( $where ); 
            
            return $this->db
                            ->get()
                            ->result_array();
    }

    public function getTotalProcess() {
    	return $this->db
                        ->count_all_results( PROCESS );
    }

    public function saveNewProcess( $db_param ) {
        $emp = $db_param[ 'emp' ];
        unset( $db_param[ 'emp' ] );

        $this->db->insert( PROCESS, $db_param );
        $proc_id = $this->db->insert_id();

        $this->insertEmpProcess( $emp, $proc_id );
    }

    public function updateProcess( $process_id, $db_param ) {
        $emp = $db_param[ 'emp' ];
        unset( $db_param[ 'emp' ] );

        $this->db
                ->where( array( 'proc_id' => $process_id ) )
                ->update( PROCESS, $db_param );

        $this->db->delete( EMP_PROCESS, array( 'process_id' => $process_id ) );

        $this->insertEmpProcess( $emp, $process_id );

        return true;
    }

    public function insertEmpProcess( $emp, $proc_id ) {
        if( count( $emp ) > 0 ) {
            for ( $i=0; $i < count( $emp ); $i++ ) {
                $emp_param = array(
                                    'user_id'       => $emp[ $i ]
                                    ,'process_id'   => $proc_id
                                  );
                $this->db->insert( EMP_PROCESS, $emp_param );
            }
        }

        return true;
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

    public function getEmpProcess( $proc_id ) {
        return $this->db
                        ->select( 'user_id' )
                        ->where( array( 'process_id' => $proc_id ) )
                        ->get( EMP_PROCESS )
                        ->result_array();
    }

}
