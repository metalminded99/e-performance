<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Abilities_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllAbilities( $offset, $per_page, $where = null ) {
        return $this->db
                        ->limit( $per_page, $offset )
                        ->get( ABILITIES )
                        ->result_array();

    }    
    
    public function getAllJobAbilities( $offset, $per_page, $where = null ) {
        $this->db
                ->select( 'A.ability_id, A.ability_code, A.ability_name, A.ability_desc, JA.job_id, JA.active' )
                ->from( JOB_ABILITIES.' JA' )
                ->join( ABILITIES.' A', 'A.ability_id = JA.ability_id' ,'LEFT' );
        
        if( !is_null( $where ) )
            $this->db->where( $where );

        $this->db
                ->limit( $per_page, $offset )
                ->order_by( 'A.ability_name', 'ASC' );

        return $this->db
                        ->get()
                        ->result_array();

    }

    public function getTotalAbilities( $table, $param = null ) {
        if( is_null( $param ) ) {
            return $this->db
                            ->count_all_results( $table );
        }else{
            return $this->db
                            ->where( $param )
                            ->count_all_results( $table );
        }
    }

    public function saveNewJobAbility( $db_param ) {
        $this->db->insert( JOB_ABILITIES, $db_param );
        return $this->db->insert_id();
    }

    public function updateJobAbility( $db_param, $where ) {
        return $this->db
                        ->where( $where )
                        ->update( JOB_ABILITIES, $db_param );
    }

    public function saveNewAbility( $db_param ) {
        $this->db->insert( ABILITIES, $db_param );
        return $this->db->insert_id();
    }

    public function updateAbility( $db_param ) {
        $param = array();
        foreach ($db_param as $key => $value) {
            if( $key != 'ability_id' ){
                $param[ $key ] = $value;
            }
        }
        
        return $this->db
                        ->where( 'ability_id', $db_param[ 'ability_id' ] )
                        ->update( ABILITIES, $param );
    }

    public function deleteAbility( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( ABILITIES );

        return true;
    }

    public function deleteJobAbility( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( JOB_ABILITIES );

        return true;
    }
    
}