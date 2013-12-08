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

    public function getPotentialAppraisalReport( $where, $by, $order ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db
                        ->select( "u.user_id, concat(u.fname, ' ', u.lname) full_name,j.job_title, ((avg(manager_score) / 5) * 100) ave, date_format(date_submit, '%b %d, %Y') date_submit", false )
                        ->group_by( 'p.user_id, manager_id' )
                        ->order_by( 'date_submit', 'desc' )
                        ->join( USER.' u', 'u.user_id = p.user_id' )
                        ->join( JOBS.' j', 'j.job_id = u.user_id' )
                        ->get( 'tbl_appraisal_potential_result p' )
                        ->result_array();

    }

    public function getPerformanceAppraisalAve( $where ) {
        // SELECT ((avg(self_score) + avg(peer_score) + avg(manager_score))/3) ave FROM `tbl_appraisal_result` where user_id = 6 and date_submit between '2013-01-01 00:00:00' and '2013-12-09 23:59:59' group by user_id
        if( !is_null( $where ) )
            $this->db->where( $where );

        $perf = $this->db
                        ->select( "((((avg(self_score) + avg(peer_score) + avg(manager_score)) / 3) / 5) * 100) ave", false )
                        ->group_by( 'user_id' )
                        ->get( 'tbl_appraisal_result' );
        return $perf->row()->ave;
    }
}