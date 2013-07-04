<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Journals_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllJournals( $offset, $per_page, $where = array() ) {
        if( !empty( $where ) )
            $this->db->where( $where );

        return $this->db
                        ->limit( $per_page, $offset )
                        ->get( JOURNALS )
                        ->result_array();

    }    
    
    public function getTotalJournals( $user_id = 0 ) {
    	return $this->db
                        ->where( 'user_id', $user_id )
                        ->count_all_results( JOURNALS );
    }

    public function saveNewJournal( $db_param ) {
        $this->db->insert( JOURNALS, $db_param );
        return $this->db->insert_id();
    }

    public function updateJournal( $db_param, $journal_id ) {        
        return $this->db
                        ->where( 'journal_id', $journal_id )
                        ->update( JOURNALS, $db_param );
    }

    public function deleteJournal( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( JOURNALS );

        return true;
    }
    
}