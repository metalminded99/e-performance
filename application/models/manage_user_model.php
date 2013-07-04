<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manage_User_Model extends CI_Model {

    protected $fld_lookup = array(
                                    'job'       => 'job_id'
                                    ,'dept'     => 'department_id'
                                    ,'address'  => 'home_address'
                                 );

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllUsers( $offset, $per_page ) {
        $db_param = array(
                            'U.lvl !=' => 1
                         );

        $this->db
                ->select( 'U.*, J.job_title, J.job_desc, D.dept_name, D.dept_desc' )
                ->from( USER.' U' )
                ->join( JOBS.' J', 'J.job_id = U.job_id', 'left' )
                ->join( DEPT.' D', 'D.dept_id = U.department_id', 'left' )
                ->where( $db_param );

        return $this->db->limit( $per_page, $offset )->get()->result_array();
    }

    public function saveNewUser( $db_param ) {
        $param = array();
        foreach ($db_param as $key => $value) {
            if( isset( $this->fld_lookup[ $key ] ) ) 
                $param[ $this->fld_lookup[ $key ] ] = $value;
            elseif ($key == 'pword')
                $param[ $key ] = md5( $value );
            else
                $param[ $key ] = $value;
        }

        $this->db->insert( USER, $param );

        return $this->db->insert_id();
    }

    public function updateUser( $db_param ) {
        $param = array();
        foreach ($db_param as $key => $value) {
            if( isset( $this->fld_lookup[ $key ] ) ) 
                $param[ $this->fld_lookup[ $key ] ] = $value;
            else{
                if( $key != 'user_id' ){
                    if(  $key == 'pword' && $db_param[ 'pword' ] == '' )
                        unset( $db_param[ 'pword'] );
                    elseif( $key == 'pword' && $db_param[ 'pword' ] != '' )
                        $param[ $key ] = md5( $value );
                    else
                        $param[ $key ] = $value;
                }
            }
        }

        return $this->db
                        ->where( 'user_id', $db_param[ 'user_id' ] )
                        ->update( USER, $param );
    }

    public function deleteUser( $db_param ){
        $this->db
                ->where( $db_param )
                ->delete( USER );

        return true;
    }

    public function getUserDetails( $uid ) {
        $db_param = array(
                            'U.user_id' => $uid
                         );

        $this->db
                ->select( 'U.*, J.job_title, J.job_desc, D.dept_name, D.dept_desc' )
                ->from( USER.' U' )
                ->join( JOBS.' J', 'J.job_id = U.job_id', 'left' )
                ->join( DEPT.' D', 'D.dept_id = U.department_id', 'left' )
                ->where( $db_param );

        return $this->db->get()->result();
    }

    public function getTotalUsers() {
        $this->db
                ->where( 'lvl != ', 1 )
                ->from( USER );
        return $this->db->count_all_results();
    }

    public function getUsersStats()  {
        return $this->db
                        ->select( 'lvl, count( * ) as total' )
                        ->from( USER )
                        ->where( array( 'lvl > ' => 1 ) )
                        ->group_by( 'lvl' )
                        ->order_by("lvl", "asc")
                        ->get()
                        ->result_array();
    }

    public function getUsersActiveStats()  {
        return $this->db
                        ->select( 'lvl, COUNT( * ) as active' )
                        ->from( USER )
                        ->where( array( 'lvl > ' => 1, 'last_login IS NOT NULL' => null ) )
                        ->group_by( 'lvl' )
                        ->order_by("lvl", "asc")
                        ->get()
                        ->result_array();
    }

}
