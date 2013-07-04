<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Trainings_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllTrainings( $offset, $per_page, $where = null ) {
        $this->db
                ->limit( $per_page, $offset );
        
        if( !is_null( $where ) )
            $this->db->where( $where );
            
        return $this->db
                        ->get( TRAININGS )
                        ->result_array();
    }

    public function getTotalTrainings( $param = null ) {
        if( is_null( $param ) ) {
            return $this->db
                            ->count_all_results( TRAININGS );
        }else{
            return $this->db
                            ->where( $param )
                            ->count_all_results( TRAININGS );
        }
    }

    public function getTrainingSkills( $training_id, $fld = 'S.skill_id' ) {
        return $this->db
                        ->select( $fld )
                        ->from( TRAINING_SKILLS.' TS' )
                        ->join( SKILLS.' S', 'S.skill_id = TS.skill_id', 'left' )
                        ->where( 'TS.training_id', $training_id )
                        ->get()
                        ->result_array();
    }

    public function getTrainingAbilities( $training_id, $fld = 'A.ability_id' ) {
        return $this->db
                        ->select( $fld )
                        ->from( TRAINING_ABL.' TA' )
                        ->join( ABILITIES.' A', 'A.ability_id = TA.ability_id', 'left' )
                        ->where( 'TA.training_id', $training_id )
                        ->get()
                        ->result_array();
    }

    public function saveNewTraining( $db_param ) {
        foreach ($db_param as $key => $value) {
            if( $key == 'skills' )
                $skills[ $key ] = $value;
            elseif( $key == 'abilities' )
                $abilities[ $key ] = $value;
            else
                $trainings[ $key ] = $value;
        }

        $this->db->insert( TRAININGS, $trainings );
        $t_id = $this->db->insert_id();
        
        $this->saveNewTrainingSkills( $t_id, $skills );
        $this->saveNewTrainingAbilities( $t_id, $abilities );

        return $this->db->insert_id();
    }

    public function saveNewTrainingSkills( $t_id, $db_param ) {
        for( $s = 0; $s < count( $db_param['skills'] ); $s++ ){
            $param = array(
                            'training_id'   => $t_id
                            ,'skill_id'      => $db_param['skills'][$s]
                          );
            $this->db->insert( TRAINING_SKILLS, $param );
        }

        return $this->db->insert_id();
    }

    public function saveNewTrainingAbilities( $t_id, $db_param ) {
        for( $s = 0; $s < count( $db_param['abilities'] ); $s++ ){
            $param = array(
                            'training_id'   => $t_id
                            ,'ability_id'   => $db_param['abilities'][$s]
                          );
            $this->db->insert( TRAINING_ABL, $param );
        }

        return $this->db->insert_id();
    }

    public function updateTraining( $db_param ) {
        $param = array();
        foreach ($db_param as $key => $value) {
            if( $key != 'training_id' ){
                $param[ $key ] = $value;
            }
        }
        
        return $this->db
                        ->where( 'training_id', $db_param[ 'training_id' ] )
                        ->update( TRAININGS, $param );
    }

    public function deleteTraining( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( TRAININGS );

        return true;
    }
    
}