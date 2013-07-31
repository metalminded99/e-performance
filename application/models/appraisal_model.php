<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Appraisal_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllAppraisal( $offset, $per_page, $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db
                        ->limit( $per_page, $offset )
                        ->get( APPRAISAL )
                        ->result_array();

    }

    public function getTotalAppraisal( $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db->count_all_results( APPRAISAL );
    }

    public function saveNewAppraisal( $db_param ) {
        $app = array( 
                        'appraisal_title' => $db_param[ 'appraisal_title' ]
                        ,'appraisal_desc' => $db_param[ 'appraisal_desc' ]
                    );
        unset($db_param[ 'appraisal_title' ]);
        unset($db_param[ 'appraisal_desc' ]);

        $this->db->insert( APPRAISAL, $app );
        $app_id = $this->db->insert_id();
        $questions = array_keys($db_param);
        for( $i = 0; $i < count( $questions ); $i ++ ){
            $cat = $questions[ $i ];
            for( $x = 0; $x < count( $db_param[  $cat ] ); $x ++ ){
                if( $db_param[ $cat ][ $x ] != '' ){
                    $q_param = array(
                                        'appraisal_id'  => $app_id
                                        ,'question'     => $db_param[ $cat ][ $x ]
                                        ,'category'     => $cat
                                    );
                    $this->db->insert( APP_QUESTION, $q_param );
                }
            }
        }
        
        return true;
    }

    public function updateAppraisal( $db_param ) {
        $param = array();
        foreach ($db_param as $key => $value) {
            if( $key != 'activity_id' ){
                $param[ $key ] = $value;
            }
        }
        
        return $this->db
                        ->where( 'activity_id', $db_param[ 'activity_id' ] )
                        ->update( APPRAISAL, $param );
    }

    public function deleteAppraisal( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( APPRAISAL );

        return true;
    }
    
}