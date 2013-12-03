<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Potential_Appraisal_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }   
    
    public function getAllPotentialAppraisal( $offset, $per_page, $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db
                        ->select( "concat(u.fname, ' ', u.lname) full_name, avg(manager_score) ave, date_format(date_submit, '%b %d, %Y') date_submit", false )
                        ->limit( $per_page, $offset )
                        ->group_by( 'p.user_id, manager_id' )
                        ->order_by( 'date_submit', 'desc' )
                        ->join( USER.' u', 'u.user_id = p.user_id' )
                        ->get( 'tbl_appraisal_potential_result p' )
                        ->result_array();

    }

    public function getTotalPotentialAppraisal( $where = null ) {
        if( !is_null( $where ) ){
            $this->db
                    ->where( $where )
                    ->group_by( 'p.user_id, p.manager_id' )
                    ->order_by( 'date_submit', 'desc' )
                    ->join( USER.' u', 'u.user_id = p.user_id' )
                    ->get( 'tbl_appraisal_potential_result p' );
        }

        return $this->db->count_all_results( APPRAISAL );
    }

    public function getPotentialAppraisalQuestion( $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db
                        ->get( 'tbl_appraisal_potential_questionaire' )
                        ->result_array();
    }

    public function addPotentialAppraisal( $db_param ) {
        return $this->db->insert_batch('tbl_appraisal_potential_result', $db_param);
    }

}