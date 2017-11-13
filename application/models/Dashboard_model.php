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
class Dashboard_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

	}

	function get_user($user_id){
		$this->db->where("user_id", $user_id);
 	  return $this->db->get("users")->row();
	}

  function get_products($user_id){
			$this->db->where("user_id", $user_id);
		  return $this->db->get("products");
	}

	function get_product($id){
			$this->db->where(array("id" => $user_id,
			                       "user_id" => $this->session->userdata("user_id")));
		  return $this->db->get("products");
	}

  function get_products_statistics_graph1($id, $options){
		$result = array("names" => array(), "tweet_counts" => array());
		$products = $this->get_products($id);

     foreach($products->result() as $product){
			 if(!in_array($product->product_name, $options) && !empty($options)) continue;
			 $tweet_count = $this->get_tweet_counts($product);

       $result['names'][] = "'".$product->product_name."'";
			 $result['tweet_counts'][] = $tweet_count['count'];
			 //$result['tweet_oral_match'][] = $tweet_count['oral_match'];
			 //$result['tweet_perfect_match'][] = $tweet_count['perfect_match'];
     }

   return $result;
  }

	function get_products_statistics_graph2($id, $options){
		$data = array("tweet_datetime" => array(), "tweet_count" => array());
		$products = $this->get_products($id);
		$data1 = array();

		$points = "";

     foreach($products->result() as $product){

			 if(!in_array($product->product_name, $options) && !empty($options)) continue;
			 $p_counts = $this->get_tweet_counts_by_time($product);


			 if(is_array($p_counts['tweet_count'])){

			 foreach($p_counts['tweet_count'] as $row){
				 $points .= '[Date.UTC('. date("Y,m,d", strtotime("-1 months", strtotime($row->datetime))).'),'.$row->tweet_count.' ],';
				 //..print_R($points);
			 }

			 }else{
				 $points .= '[Date.UTC('. date("Y,m,d", strtotime("-1 months")).'), 0],';

			 }

			 $data1[$product->product_name]["points"] = '['.$points.']';
			 $points = "";
     }

   return $data1;
  }

	function get_tweet_counts($product){
		$result = array();

		$this->db->select("count(id) as count");
    $this->db->order_by("id", "desc");
		$this->db->where("product_id", $product->id)->limit("1");
		$statistics = $this->db->get("tweets");

		$result['count'] = 0;

		if($statistics->num_rows() > 0){
			 $result['count'] = $statistics->row()->count;
		}

		return $result;

  }


	function get_tweet_count($product){
		$result = array();

		$this->db->select("COUNT(id) as tweet_count");
		$this->db->where("product_id", $product->id);
		$tweet_count = $this->db->get("tweets");

		$result['tweet_count'] = 0;

		if($tweet_count->num_rows() > 0){
     $result['tweet_count'] = $tweet_count->row()->tweet_count;
	  }

    $result['oral_count'] = 0;
    $result['perfect_count'] = 0;

		return $result;

  }

	function get_tweet_counts_by_time($product){
		$result = array();

		$this->db->select("COUNT(*) as tweet_count, datetime");
		$this->db->where("product_id", $product->id);
		$this->db->group_by("DATE(datetime)");
		$tweet_count = $this->db->get("tweets");

		$result['tweet_count'] = 0;

		if($tweet_count->num_rows() > 0){
     $result['tweet_count'] = $tweet_count->result();
	  }

		return $result;

  }


	function update_product_statistics_graph1($product){

		$product_count = $this->get_tweet_count($product);
    $product_count['product_id'] = $product->id;
		$product_count['datetime'] = date("Y-m-d H:i:s");

		$this->db->where("product_id", $product->id);
		$this->db->delete("product_statistics");

		$this->db->insert("product_statistics", $product_count);

		$p_counts = $this->get_tweet_counts_by_time($product);

		$data = array();
		$data1 = array();

		if(is_array($p_counts['tweet_count'])){

		foreach($p_counts['tweet_count'] as $row){
      $data["tweet_datetime"][] = strtotime($row->datetime);
			$data["tweet_count"][] = $row->tweet_count;
		}

		}else{
			$data["tweet_datetime"][] = strtotime(date("Y-m-d H:i:s"));
			$data["tweet_count"][] = "0";
	  }

		$data1["tweet_datetime"] = implode(", ", $data["tweet_datetime"]);
		$data1["tweet_count"] = implode(", ", $data["tweet_count"]);


		if(is_array($p_counts['oral_count'])){

		foreach($p_counts['oral_count'] as $row){
      $data["oral_datetime"][] = strtotime($row->datetime);
			$data["oral_count"][] = $row->oral_count;
		}

		}else{
			$data["oral_datetime"][] = strtotime(date("Y-m-d H:i:s"));
			$data["oral_count"][] = "0";
	  }

		$data1["oral_datetime"] = implode(", ", $data["oral_datetime"]);
		$data1["oral_count"] = implode(", ", $data["oral_count"]);

		if(is_array($p_counts['perfect_count'])){

		foreach($p_counts['perfect_count'] as $row){
      $data["perfect_datetime"][] = strtotime($row->datetime);
		  $data["perfect_count"][] = $row->perfect_count;
		}

		}else{
			$data["perfect_datetime"][] = strtotime(date("Y-m-d H:i:s"));
			$data["perfect_count"][] = "0";
	  }

		$data1["perfect_datetime"] = implode(",", $data["perfect_datetime"]);
		$data1["perfect_count"] = implode(",", $data["perfect_count"]);

		$data1['datetime'] = date("Y-m-d H:i:s");
		$data1['product_id'] = $product->id;

		$this->db->where("product_id", $product->id);
		$this->db->delete("product_timeline_statistics");

		//print_r($data1);die;

    $this->db->insert("product_timeline_statistics", $data1);
  }
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */
