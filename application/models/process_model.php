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
    
    public function getAllEmpProcess( $offset, $per_page, $where = array() ) {
            $this->db
                    ->select( 'p.proc_id, p.proc_title, p.proc_desc, p.start_date, p.end_date, ep.date_assigned, ep.status' )
                    ->from( EMP_PROCESS.' ep' )
                    ->join( PROCESS.' p', 'p.proc_id = ep.process_id', 'left' )
                    ->order_by( 'p.date_added', 'DESC' )
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

    public function getTotalEmpProcess( $where = array() ) {
        if( !empty($where) )
            $this->db->where( $where );

    	return $this->db
                        ->count_all_results( EMP_PROCESS );
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
                        'ep.user_id' => $user_id
                        ,"DATE(SYSDATE()) >= p.start_date" => null
                        ,"DATE(SYSDATE()) <= p.end_date" => null
                        ,"ep.date_accomplished" => null
                      );

        return $this->db
                        ->where( $where )
                        ->join( PROCESS.' p', 'p.proc_id = ep.process_id', 'left' )
                        ->count_all_results( EMP_PROCESS.' ep' );
    }

    public function getEmpProcess( $proc_id ) {
        return $this->db
                        ->select( 'user_id' )
                        ->where( array( 'process_id' => $proc_id ) )
                        ->get( EMP_PROCESS )
                        ->result_array();
    }

    public function getEmpProcessReport( $where, $by, $order = 'ASC' ) {
        return $this->db
                        ->select( "CONCAT( u.fname,  ' ', u.lname ) full_name, p.proc_title, p.proc_desc, DATE_FORMAT(p.start_date,'%b %d, %Y') start_date, DATE_FORMAT(p.end_date,'%b %d, %Y') end_date, DATE_FORMAT(ep.date_accomplished,'%b %d, %Y') date_accomplished", FALSE )
                        ->from( EMP_PROCESS.' ep' )
                        ->join( PROCESS.' p', 'p.proc_id = ep.process_id', 'left' )
                        ->join( USER.' u', 'u.user_id = ep.user_id', 'left' )
                        ->where( $where )
                        ->order_by( $by, $order )
                        ->get()
                        ->result_array();
    }

    public function updateEmpProcess( $process_id, $user_id, $db_param ) {
        $this->db
                ->where( 'process_id', $process_id )
                ->where( 'user_id', $user_id )
                ->update( EMP_PROCESS, $db_param );

        return true;
    }

    public function insertEmpProcessComment( $db_data ) {
        $this->db->insert( EMP_PROCESS_COM, $db_data );

        return true;
    }

    public function getEmpProcessComment( $proc_id, $user_id ) {
        return $this->db
                        ->select( "comment, DATE_FORMAT(date_comment, '%M %d, %Y') date_comment", false )
                        ->where( 'proc_id', $proc_id )
                        ->where( 'user_id', $user_id )
                        ->get( EMP_PROCESS_COM )
                        ->result_array();
    }

    public function getProcessSummary( $status ) {
        return $this->db
                        ->select( "p.proc_title, count(*) total", false )
                        ->join( PROCESS .' p', 'p.proc_id = ep.process_id', 'left' )
                        ->where( 'ep.status', $status )
                        ->group_by( 'ep.process_id' )
                        ->get( EMP_PROCESS.' ep' )
                        ->result_array();
    }

}
