<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Database actions for free_agent controller
 *
 * This model represents user authentication data. It operates the following tables:
 * - user account data,
 * - user token
 * - user profile
 *
 * @package	Free_agent_model
 * @author	muthukrishnan (http://muthu.tk/)
 */
class Tc_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

	}

  function get_products($method){

		if($method == "refresh"){
			$this->db->where("is_new", "0");
  		$this->db->order_by("last_search", "asc");
  		$this->db->limit("5");
		}else{
			$this->db->where("is_new", "1");
			$this->db->order_by("id", "asc");
			$this->db->limit("5");
		}

		return $this->db->get("products");
	}

	function update_token_reset($id, $date){
		$this->db->where("user_id", $id);
		$this->db->update("users", array("search_reset" => $date));
	}

	function save_tweets($product, $tweets, $meta){

		if(!empty($tweets)) $this->db->insert_batch("tweets", $tweets);

		if($product->since_id < $meta->max_id_str || $product->since_id == "0") $data['since_id'] = $meta->max_id_str;

    //print_r("<pre>");print_r($meta);print_R(count($tweets));print_R("</pre>");//die;

		if(count($tweets) == 100){
			$ok = false;
			$max_id = "0";

			foreach(explode("&", str_replace("?", "", $meta->next_results)) as $key => $value){
				$id = explode("=", $value);
				if($id['0'] == "max_id"){
					 $max_id = $id['1'];
				 }
			}

			$data['max_id'] = $max_id;
      $data['last_search'] = date("Y-m-d H:i:s");
			$this->db->where("id", $product->id);
	    $this->db->update("products", $data);
			return true;
		}else{
			$data['is_new'] = "0";
			$data['last_search'] = date("Y-m-d H:i:s");
			$this->db->where("id", $product->id);
	    $this->db->update("products", $data);
			return false;
		}
	}

	function get_product($id, $type){
		$this->db->where("id", $id)->limit("1");
		return $this->db->get("products")->result()['0'];
	}

	function update_search_time($product){
		$data['last_search'] = date("Y-m-d H:i:s");
		$this->db->where("id", $product->id);
		$this->db->update("products", $data);
	}

	function get_product_count($id){
		$this->db->select("products.id as product_id, products.product_name, product_statistics.*");
		$this->db->from("product_statistics");
		$this->db->join("products", "products.id = product_statistics.product_id");
	  $this->db->where("product_statistics.product_id", $id);
		$this->db->order_by("product_statistics.id", "desc")->limit("1");
		return $this->db->get();
	}

	function get_product_stat($id){
		$this->db->select("product_timeline_statistics.*");
		$this->db->from("product_timeline_statistics");
    $this->db->where("product_timeline_statistics.product_id", $id);
		$this->db->order_by("product_timeline_statistics.id", "desc")->limit("1");
    return $this->db->get();
	}

	function check_access($id){

		if(!is_numeric($id)){
			 $this->db->where(array("product_name" => $id, "user_id" => $this->session->userdata("user_id")));
		}else{
			 $this->db->where(array("id" => $id, "user_id" => $this->session->userdata("user_id")));
		}

		$product = $this->db->get("products");

		if($product->num_rows() == 0) die;

		return $product->row();
  }
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */
