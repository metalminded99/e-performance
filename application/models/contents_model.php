<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contents_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getAllNews( $offset, $per_page, $db_param = null ) {
        $this->db
                ->limit( $per_page, $offset );
        if( !is_null( $db_param ) )
            $this->db->where( $db_param ); 
        
        return $this->db->get( NEWS )->result_array();
    }

    public function getTotalNews() {
    	return $this->db->count_all( NEWS );
    }

    public function saveNewNews( $db_param ) {
        $this->db->insert( NEWS, $db_param );
        return $this->db->insert_id();
    }

    public function updateNews( $db_param ) {
        $param = array();
        foreach ($db_param as $key => $value) {
            if( $key != 'news_id' ){
                $param[ $key ] = $value;
            }
        }
        
        return $this->db
                        ->where( 'news_id', $db_param[ 'news_id' ] )
                        ->update( NEWS, $param );
    }

    public function deleteNews( $db_param ) {
        $this->db
                ->where( $db_param )
                ->delete( NEWS );

        return true;
    }

}
