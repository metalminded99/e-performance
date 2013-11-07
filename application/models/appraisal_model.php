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

    public function getAppraisalMainCategories( $where = null, $offset = null, $per_page = 1000 ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db
                        ->limit( $per_page, $offset )
                        ->get( APP_MAIN_CAT )
                        ->result_array();
    }

    public function getAppraisalSubCategories( $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db
                        ->get( APP_SUB_CAT )
                        ->result_array();
    }

    public function addAppraisalMainCategories( $db_param ) {
        $this->db->insert( APP_MAIN_CAT, $db_param );
        return $this->db->insert_id();
    }

    public function addAppraisalSubCategories( $db_param ) {
        $this->db->insert( APP_SUB_CAT, $db_param );
        return $this->db->insert_id();
    }

    public function removeAppraisalSubCategories( $db_param ) {
        $this->db->delete( APP_SUB_CAT, $db_param );
        return true;
    }

    public function removeAppraisalMainCategories( $db_param ) {
        $this->db->delete( APP_MAIN_CAT, $db_param );
        return true;
    }

    public function updateAppraisalSubCategories( $db_param, $where ) {
        $this->db
                ->where( $where )
                ->update( APP_SUB_CAT, $db_param );
        return true;
    }

    public function updateAppraisalMainCategories( $db_param, $where ) {
        $this->db
                ->where( $where )
                ->update( APP_MAIN_CAT, $db_param );
        return true;
    }

    public function getAppraisalQuestion( $app_id, $cat, $sub_cat ) {
        return $this->db
                        ->where( 
                                    array( 
                                            'appraisal_id'  => $app_id 
                                            ,'category'     => $cat
                                            ,'sub_category' => $sub_cat
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
        unset($db_param[ 'module' ]);
        unset($db_param[ 'step' ]);

        $this->db->insert( APPRAISAL, $app );
        $app_id = $this->db->insert_id();

        for( $i = 0; $i < count( $db_param ); $i ++ ){
            foreach ($db_param[$i] as $key => $value) {
                if( preg_match( '/question/', $key ) ) {
                    $sub_cat = explode('_', $key);
                    for( $q = 0; $q < count( $db_param[$i][$key] ); $q++ ){
                        $q_param = array(
                                            'appraisal_id'  => $app_id
                                            ,'question'     => $db_param[$i][$key][$q]
                                            ,'category'     => $db_param[$i]['module']
                                            ,'sub_category' => end( $sub_cat )
                                        );
                        $this->db->insert( APP_QUESTION, $q_param );
                    }
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
        unset($db_param[ 'module' ]);
        unset($db_param[ 'step' ]);

        $this->db
                ->where( array( 'appraisal_id' => $app_id ) )
                ->update( APPRAISAL, $app );

        $this->db->delete( APP_QUESTION, array( 'appraisal_id' => $app_id ) );
        
        for( $i = 0; $i < count( $db_param ); $i ++ ){
            foreach ($db_param[$i] as $key => $value) {
                if( preg_match( '/question/', $key ) ) {
                    $sub_cat = explode('_', $key);
                    for( $q = 0; $q < count( $db_param[$i][$key] ); $q++ ){
                        $q_param = array(
                                            'appraisal_id'  => $app_id
                                            ,'question'     => $db_param[$i][$key][$q]
                                            ,'category'     => $db_param[$i]['module']
                                            ,'sub_category' => end( $sub_cat )
                                        );
                        $this->db->insert( APP_QUESTION, $q_param );
                    }
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
        $user_exist = $this->db
                              ->where( array( 'user_id' => $db_data['user_id'], 'app_id' => $db_data['app_id'] ) )
                              ->get( APP_ASSIGN )
                              ->result_array( );
        if( count( $user_exist ) == 0 ){
            $this->db->insert(
                                APP_ASSIGN
                                ,array(
                                        'user_id'   => $db_data['user_id']
                                        ,'app_id'   => $db_data['app_id']
                                        ,'status'   => $db_data['status']
                                      ) 
                             );
            $assign_id = $this->db->insert_id();
        }else{
            $assign_id = $user_exist[0]['assign_id'];
        }
        
        $mngr_exist = $this->db
                                ->where( array( 'assign_id' => $assign_id ) )
                                ->count_all_results( APP_MNGR_ASSIGN );
        if( $mngr_exist == 0 ){
            $this->db->insert( 
                                APP_MNGR_ASSIGN
                                ,array(
                                        'assign_id'     => $assign_id
                                        ,'manager_id'   => $db_data['manager_id']
                                        ,'status'       => $db_data['status']
                                      ) 
                            );
        }

        $peer_exist = $this->db
                                ->where( array( 'assign_id' => $assign_id ) )
                                ->count_all_results( APP_PEER_ASSIGN );
        if( $peer_exist == 0 ){
            return $this->db->insert( 
                                        APP_PEER_ASSIGN
                                        ,array(
                                                'assign_id' => $assign_id
                                                ,'peer_id'  => $db_data['peer_id']
                                                ,'status'   => $db_data['status']
                                              ) 
                                    );
        }else{
            return false;
        }
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
                        ->select( "aa.app_id, u.user_id, CONCAT(u.fname,' ',u.lname) full_name, pa.status, aa.date_assigned", FALSE )
                        ->from( APP_ASSIGN.' aa' )
                        ->join( APP_PEER_ASSIGN.' pa', 'pa.assign_id = aa.assign_id', 'left' )
                        ->join( USER.' u', 'u.user_id = pa.peer_id', 'left' )
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
                        ->select( "a.appraisal_title, avg(ar.self_score) self_score, avg(ar.peer_score) peer_score, avg(ar.manager_score) manager_score, ar.date_submit", false )
                        ->from( APP_RESULT.' ar' )
                        ->join( APPRAISAL.' a', 'a.appraisal_id = ar.appraisal_id', 'left' )
                        ->where( array( 'ar.user_id' => $user_id ) )
                        ->group_by( 'ar.user_id, a.appraisal_id' )
                        ->get()
                        ->result_array();
    }

    public function getAllEmployeeFeedbackResult( $user_id ) {
        return $this->db
                        ->select( 'COUNT( DISTINCT user_id, appraisal_id ) AS  `numrows`', false )
                        ->where( array( 'user_id' => $user_id ) )
                        ->group_by( 'user_id' )
                        ->get( APP_RESULT )
                        ->row()
                        ->numrows;
    }

    public function getSelfFeedbackCount( $user_id ) {
        return $this->db
                        ->where( array( 'user_id' => $user_id, 'status !=' => 'Completed' ) )
                        ->count_all_results( APP_ASSIGN );
    }

    public function getPeerFeedbackCount( $user_id ) {
        return $this->db
                        ->where( array( 'peer_id' => $user_id, 'status !=' => 'Completed' ) )
                        ->count_all_results( APP_PEER_ASSIGN );
    }

    public function getMngrFeedbackCount( $user_id ) {
        return $this->db
                        ->where( array( 'manager_id' => $user_id, 'status !=' => 'Completed' ) )
                        ->count_all_results( APP_MNGR_ASSIGN );
    }

    public function getFeedbackQuestion( $q_param ) {
        return $this->db
                        ->where( $q_param )
                        ->join( APP_SUB_CAT.' sc', 'sc.sub_category_id = q.sub_category', 'left' )
                        ->get( APP_QUESTION.' q' )
                        ->result_array();
    }

    public function getSelfFeedback( $per_page, $offset, $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db
                        ->select( 'tas.app_id, a.appraisal_title, tas.date_assigned, tas.status' )
                        ->from( APP_ASSIGN.' tas' )
                        ->join( APPRAISAL.' a', 'a.appraisal_id = tas.app_id', 'left' )
                        ->group_by( 'tas.app_id, tas.user_id' )
                        ->limit( $offset, $per_page )
                        ->get()
                        ->result_array();
    }

    public function getPeerFeedback( $per_page, $offset, $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

         return $this->db
                        ->select( 'tas.app_id, pa.assign_id, a.appraisal_title, tas.date_assigned, pa.status' )
                        ->from( APP_PEER_ASSIGN.' pa' )
                        ->join( APP_ASSIGN.' tas', 'tas.assign_id = pa.assign_id', 'left' )
                        ->join( APPRAISAL.' a', 'a.appraisal_id = tas.app_id', 'left' )
                        ->group_by( 'tas.app_id, pa.peer_id' )
                        ->limit( $offset, $per_page )
                        ->get()
                        ->result_array();
    }

    public function getMngrFeedback( $per_page, $offset, $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

         return $this->db
                        ->select( 'tas.app_id, pa.assign_id, a.appraisal_title, tas.date_assigned, pa.status' )
                        ->from( APP_MNGR_ASSIGN.' pa' )
                        ->join( APP_ASSIGN.' tas', 'tas.assign_id = pa.assign_id', 'left' )
                        ->join( APPRAISAL.' a', 'a.appraisal_id = tas.app_id', 'left' )
                        ->limit( $offset, $per_page )
                        ->get()
                        ->result_array();
    }
    
    public function insertFeedbackForm( $feedback ) {
        $where = array(
                        'user_id'       => $feedback[ 'user_id' ]
                        ,'question_id'  => $feedback[ 'question_id' ]
                        ,'appraisal_id' => $feedback[ 'appraisal_id' ]
                      );

        $exist = $this->db
                          ->where( $where )
                          ->count_all_results( APP_RESULT );

        if( !$exist ){
            return $this->db->insert( APP_RESULT, $feedback );
        }
        else{
            if ( isset( $feedback[ 'peer_id' ] ) ){
                $up_data = array( 'peer_id' => $feedback[ 'peer_id' ], 'peer_score' => $feedback[ 'peer_score' ] );
            }elseif ( isset( $feedback[ 'manager_id' ] ) ){
                $up_data = array( 'manager_id' => $feedback[ 'manager_id' ], 'manager_score' => $feedback[ 'manager_score' ] );
            }

            return $this->db
                            ->where( $where )
                            ->update( APP_RESULT, $up_data );
        }
    }

    public function updateFeedbackStatus( $db_param, $table ){ 
        return $this->db->where( $db_param )->update( $table, array( 'status' => 'Completed' ) );
    }

    public function getFeedbackSummary( $field, $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db
                        ->select( 'mc.main_category_id, mc.main_category_name, AVG( ar.'.$field.' ) ave' )
                        ->from( APP_RESULT.' ar' )
                        ->join( APP_QUESTION.' aq', 'aq.question_id = ar.question_id', 'left' )
                        ->join( APP_MAIN_CAT.' mc', 'mc.main_category_id = aq.category', 'left' )
                        ->group_by( 'mc.main_category_id' )
                        ->get()
                        ->result_array();
    }

    public function getFeedbackSummarySubCat( $field, $where = null ) {
        if( !is_null( $where ) )
            $this->db->where( $where );

        return $this->db
                        ->select( 'sc.sub_category_name, AVG( ar.'.$field.' ) ave' )
                        ->from( APP_RESULT.' ar' )
                        ->join( APP_QUESTION.' aq', 'aq.question_id = ar.question_id', 'left' )
                        ->join( APP_SUB_CAT.' sc', 'sc.main_cat_id = aq.category', 'left' )
                        ->group_by( 'sc.sub_category_id' )
                        ->get()
                        ->result_array();
    }

    public function getAssignedEmployee( $assign_id, $app_id ) {
        return $this->db
                        ->select( 'user_id' )
                        ->where( array( 'assign_id' => $assign_id, 'app_id' => $app_id ) )
                        ->limit( 1 )
                        ->get( APP_ASSIGN )
                        ->result_array();
    }

    public function getMngrViewSummary( $dept_id ) {
        return $this->db
                        ->select( "aq.category,concat(u.fname,' ', u.lname) full_name, ((avg(self_score) + avg(peer_score) + avg(manager_score)) / 3) total_score", false )
                        ->from( APP_RESULT.' ar' )
                        ->join( USER.' u', 'u.user_id = ar.user_id', 'left' )
                        ->join( APP_QUESTION.' aq', 'aq.question_id = ar.question_id', 'left' )
                        ->where( 'u.department_id', $dept_id )
                        ->group_by( 'ar.user_id, aq.category' )
                        ->get()
                        ->result_array();
    }

    public function getPerformanceSummary() {
        return $this->db
                        ->select( "year(date_submit)dsy, month(date_submit) dsm, avg(self_score) sc, avg(peer_score)ps, avg(manager_score) ms", false )
                        ->group_by( 'year(date_submit), month(date_submit)' )
                        ->order_by( 'year(date_submit), month(date_submit)', 'asc' )
                        ->get( APP_RESULT )
                        ->result_array();
    }

}