<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Succession_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllSuccessionCat( $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );
        
        return $this->db
                        ->get( SUCC_MAST )
                        ->result_array();

    }
    
    public function getEmployeeSuccession( $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );
        
        return $this->db
                        ->get( SUCC_PLAN )
                        ->result_array();

    }

    public function getEmployeeSuccessionDetails( $user_id ) {        
        return $this->db->query('SELECT * FROM 
                                ( SELECT sm.desc potential FROM tbl_succession_plan sp LEFT JOIN `tbl_succession_master`  sm ON sm.`id` = sp.`potential` where sp.user_id = '.$user_id.' ) potential,
                                ( SELECT sm.desc timing FROM tbl_succession_plan sp LEFT JOIN `tbl_succession_master`  sm ON sm.`id` = sp.`timing` where sp.user_id = '.$user_id.' ) timing,
                                ( SELECT sm.desc risk_of_leaving FROM tbl_succession_plan sp LEFT JOIN `tbl_succession_master`  sm ON sm.`id` = sp.`risk_of_leaving` where sp.user_id = '.$user_id.' ) risk,
                                ( SELECT sm.desc reason_for_leaving FROM tbl_succession_plan sp LEFT JOIN `tbl_succession_master`  sm ON sm.`id` = sp.`reason_for_leaving` where sp.user_id = '.$user_id.' ) reason')
                        ->result_array();

    }
    
    public function setEmployeeSuccession( $db_data, $user_id ) {
        $check = $this->db
                        ->from( SUCC_PLAN )
                        ->where( 'user_id', $user_id )
                        ->count_all_results( );
        if( $check ){
            return $this->db
                            ->where( 'user_id', $user_id )
                            ->update( SUCC_PLAN, $db_data );
        }else{
            $user = array( 'user_id' => $user_id );
            $this->db->insert( SUCC_PLAN, array_merge($user, $db_data ) );
            return $this->db->insert_id();
        }

    }
    
}