<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dev_Plan_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllDevPlan( $offset, $per_page, $where = array() ) {
            $this->db
                    ->select( 'ED.user_id, ED.training_id, ED.date_assigned, ED.date_start, ED.date_end,  ED.status, T.training_title, T.training_desc' )
                    ->from( DEV_PLAN.' ED' )
                    ->join( TRAININGS.' T', 'T.training_id = ED.training_id', 'left' )
                    ->order_by( 'ED.date_assigned', 'ASC' )
                    ->limit( $per_page, $offset );
            
            if( !is_null( $where ) )
                $this->db->where( $where ); 
            
            return $this->db
                            ->get()
                            ->result_array();
    }

    public function getTotalDevPlan( $user_id ) {
    	return $this->db
                        ->where( array( 'user_id' => $user_id ) )
                        ->count_all_results( DEV_PLAN );
    }

    public function getDevPlanSkills( $training_id ){
        return $this->db
                        ->select( 'TS.skill_id, S.skill_name' )
                        ->from( TRAINING_SKILLS.' TS' )
                        ->join( SKILLS.' S', 'S.skill_id = TS.skill_id', 'left' )
                        ->where( 'TS.training_id', $training_id )
                        ->get()
                        ->result_array();
    }

    public function getDevPlanAbilities( $training_id ){
        return $this->db
                        ->select( 'TA.ability_id, A.ability_name' )
                        ->from( TRAINING_ABL.' TA' )
                        ->join( ABILITIES.' A', 'A.ability_id = TA.ability_id', 'left' )
                        ->where( 'TA.training_id', $training_id )
                        ->get()
                        ->result_array();
    }

    public function saveNewEmpDevPlan( $db_param ) {
        $this->db->insert( DEV_PLAN, $db_param );
        return $this->db->insert_id();
    }

    public function updateEmpDevPlan( $training_id, $db_param ) {
        return $this->db
                        ->where( 'training_id', $training_id )
                        ->update( DEV_PLAN, $db_param );
    }

    public function deleteEmpDevPlan( $training_id ) {
        $this->db
                ->where( array( 'training_id' => $training_id ) )
                ->delete( DEV_PLAN );

        return true;
    }

}
