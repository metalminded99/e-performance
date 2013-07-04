<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
    
    public function getTransaction(){
        $sql = "SELECT t.*, c.name, p.product_name, DATE_FORMAT( t.date_purchased ,  '%M %d, %Y' ) date_buy 
                FROM  `transaction` t
                LEFT JOIN customer c ON c.customer_id = t.customer_id
                LEFT JOIN products p ON p.product_id = t.product_id";
        $query = $this->db->query($sql);

        return $query->result();
    }
}