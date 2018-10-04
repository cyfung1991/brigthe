<?php
class Product_model extends CI_Model {
 function __construct() {
	 parent::__construct();
 }

 public function get_product_list( $start, $limit, $sort_by, $order, $status = 1 ) {
	 // return array
	 $return_arr = array(
		 'total' => 0,
		 'records' => array()
	 );
	 // return total row in the table
	 $return_arr['total'] = $this->db->where("status = $status")->count_all_results('product');
	 # Query:
	 # SELECT * FROM product
	 # WHERE status = ? // 1 = Live, 0 = Deleted
	 # ORDER BY product_id ASC
	 # LIMIT $limit, $start
	 $query = $this->db->where("status = $status")
	 ->order_by($sort_by, $order)
	 ->limit($limit, $start)
	 ->get('product');
	 $return_arr['records'] = $query->result_array();
	 return $return_arr;
 }

 public function get_product_details( $product_id ){
   $query = $this->db->where("product_id = $product_id")->get('product');
   return $query->result_array();
 }

 public function insert_product( $insert_arr ){
	 return $this->db->insert('product', $insert_arr);
 }

 public function update_product( $update_arr, $product_id ){
	 $this->db->where('product_id', $product_id);
	 return $this->db->update('product', $update_arr);
 }
}
