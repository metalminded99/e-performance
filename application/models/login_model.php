<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function verify( $params, $site = 'admin' ){
        $lvl = $site == 'admin' ? array( 'U.lvl' => 1 ) : array( 'U.lvl > ' => 1 );
        $db_param = array(
                            'U.uname' => $params['user_name']
                            ,'U.pword' => md5( $params['user_password'] )
                         );

        $this->db
                ->select( 'U.*, J.job_title, J.job_desc, D.dept_name, D.dept_desc' )
                ->from( USER.' U' )
                ->join( JOBS.' J', 'J.job_id = U.job_id', 'left' )
                ->join( DEPT.' D', 'D.dept_id = U.department_id', 'left' )
                ->where( array_merge( $db_param, $lvl ) );

        return $this->db->get()->result_array();
    }

    public function stamp_last_login( $params ){
        $now = array(
                        'last_login' => date( 'Y-m-d H:i:s' )
                    );

        $this->db->where( $params );
        $this->db->update( USER, $now );
    }

    public function checkUserPassword( $where ) {
        return $this->db
                        ->where( $where )
                        ->from( USER )
                        ->count_all_results();
    }

    public function changePassword( $new_pword, $user_id ){
        return $this->db
                        ->where( $user_id )
                        ->update( USER, $new_pword );
    }

    public function updateUserContacts( $where, $param ){
        return $this->db
                        ->where( $where )
                        ->update( USER, $param );
    }
}
