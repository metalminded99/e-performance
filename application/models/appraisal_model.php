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

    public function getAppraisalQuestion( $app_id, $cat ) {
        return $this->db
                        ->where( 
                                    array( 
                                            'appraisal_id'  => $app_id 
                                            ,'category'     => $cat
                                          )
                                )
                        ->get( APP_QUESTION )
                        ->result_array();
    }

    public function saveNewAppraisal( $db_param ) {
        $app = array( 
                        'appraisal_title'   => $db_param[ 'appraisal_title' ]
                        ,'appraisal_desc'   => $db_param[ 'appraisal_desc' ]
                        ,'job_id'           => $db_param[ 'job_id' ]
                    );
        unset($db_param[ 'appraisal_title' ]);
        unset($db_param[ 'appraisal_desc' ]);
        unset($db_param[ 'job_id' ]);

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

    public function updateAppraisal( $app_id, $db_param ) {
        $app = array( 
                        'appraisal_title'   => $db_param[ 'appraisal_title' ]
                        ,'appraisal_desc'   => $db_param[ 'appraisal_desc' ]
                    );
        unset($db_param[ 'appraisal_title' ]);
        unset($db_param[ 'appraisal_desc' ]);
        unset($db_param[ 'job_id' ]);

        $this->db
                ->where( array( 'appraisal_id' => $app_id ) )
                ->update( APPRAISAL, $app );

        $this->db->delete( APP_QUESTION, array( 'appraisal_id' => $app_id ) );
        
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

    public function deleteAppraisal( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( APPRAISAL );

        return true;
    }

    public function assignEmployeeFeedback( $db_data ) {
        $exist = $this->db
                          ->where( array( 'user_id' => $db_data['user_id'], 'peer_id' => $db_data['peer_id'] ) )
                          ->count_all_results( APP_ASSIGN );
        if( $exist == 0 ){
            $this->db->insert( APP_ASSIGN, $db_data );
            return true;
        }else
            return false;
    }

    public function getAssignedFeedback( $per_page, $offset, $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db                        
                        ->limit( $per_page, $offset )
                        ->get( APP_ASSIGN )
                        ->result_array();
    }

    public function getTotalAssignedFeedback( $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db->count_all_results( APP_ASSIGN );
    }

    public function getAssignedFeedbackHistory( $where ) {
        return $this->db
                        ->select( "aa.app_id, u.user_id, CONCAT(u.fname,' ',u.lname) full_name, aa.status, aa.date_assigned", FALSE )
                        ->from( APP_ASSIGN.' aa' )
                        ->join( USER.' u', 'u.user_id = aa.peer_id', 'left' )
                        ->where( $where )
                        ->get()
                        ->result_array();
    }

    public function deleteAssignEmployeeFeedback( $db_data ) {
        return $this->db
                        ->delete( APP_ASSIGN, $db_data );
    }

    public function getEmployeeFeedbackResult( $per_page, $offset, $user_id ) {
        return $this->db
                        ->select( "a.appraisal_title, ar.self_score, ar.peer_score, ar.manager_score, ar.date_submit" )
                        ->from( APP_RESULT.' ar' )
                        ->join( APPRAISAL.' a', 'a.appraisal_id = ar.appraisal_id', 'left' )
                        ->where( array( 'ar.user_id' => $user_id ) )
                        ->get()
                        ->result_array();
    }

    public function getAllEmployeeFeedbackResult( $user_id ) {
        return $this->db
                        ->where( array( 'user_id' => $user_id ) )
                        ->count_all_results( APP_RESULT );
    }

    public function getSelfFeedbackCount( $user_id ) {
        return $this->db
                        ->where( array( 'user_id' => $user_id ) )
                        ->count_all_results( APP_ASSIGN );
    }

    public function getPeerFeedbackCount( $user_id ) {
        return $this->db
                        ->where( array( 'peer_id' => $user_id ) )
                        ->count_all_results( APP_ASSIGN );
    }

    public function getMngrFeedbackCount( $user_id ) {
        return $this->db
                        ->where( array( 'manager_id' => $user_id ) )
                        ->count_all_results( APP_ASSIGN );
    }

    public function getSelfFeedback( $per_page, $offset, $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db                        
                        ->limit( $per_page, $offset )
                        ->get( APP_ASSIGN )
                        ->result_array();
    }
    
}