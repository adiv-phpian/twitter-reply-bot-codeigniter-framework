<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Twitter_cron extends CI_Controller
{

	public $count;
	public $method;

	function __construct()
	{
		parent::__construct();
		$this->load->library("OAuth");
		$this->load->model("tc_model");

		$this->count = 0;
		$this->method = "";

		$this->settings = array('consumer_key' => $this->config->item("twitter_consumer_key"),
                            'consumer_secret' => $this->config->item("twitter_consumer_secret"));

	}

	function collect_tweets_for_new_products()
	{
		$this->method = "next";
		$this->get_tweets_for_products();
	}

	function collect_tweets_for_existing_products()
	{
		$this->method = "refresh";
		$this->get_tweets_for_products();
	}

	private function get_tweets_for_products(){
   $products = $this->tc_model->get_products($this->method);

	 foreach($products->result() as $product){
     $this->retrieve_tweets($product);
	 }
  }

	private function retrieve_tweets($product){
		$product = $this->tc_model->get_product($product->id, $this->method);
		//print_r($product);//die;
    $token = $this->get_c_tokens($product->user_id);

    if($token){
			$this->settings['oauth_token'] = $token->oauth_token;
      $this->settings['oauth_token_secret'] = $token->oauth_secret;
			$con = $this->OAuth->connect($this->settings);
			$this->search_and_update($con, $product);
	  }else{
			$this->tc_model->update_search_time($product);
		}
  }

	private function get_c_tokens($user_id){
		$this->db->where("user_id", $user_id);
		$this->db->where("search_reset < ", date("Y-m-d H:i:s"));

		$result =  $this->db->get("users");

		if($result->num_rows() > 0){
			return $result->row();
		}else{
			return false;
		}
	}

	private function search_and_update($con, $product){
    $this->count = $this->count+1;

		if($this->count > 20){
			 //$this->tc_model->update_token_reset($token->id, date("Y-m-d H:i:s", strtotime("+15 minutes")));
			 die("end reached");
		}

		$response = $this->OAuth->search($con, $product, $this->method);

		$tweets = array();

		if(!isset($response->statuses)){
			$this->tc_model->update_token_reset($product->user_id, date("Y-m-d H:i:s", strtotime("+15 minutes")));
			return;
		}
    //print_r($response);//die("0000");//die;die;
		foreach($response->statuses as $tweet){

			$tweets[] = array("tweet_id" => $tweet->id_str,
						            "tweet" => json_encode($tweet->text),
												"datetime" => date("Y-m-d H:i:s", strtotime($tweet->created_at)),
											  "tweet_json" => json_encode($tweet),
											  "product_id" => $product->id,
												"product_name" => $product->product_name,
											  "user_id" => $product->user_id);
		}

    $response = $this->tc_model->save_tweets($product, $tweets, $response->search_metadata);

    if($response == true) $this->retrieve_tweets($product);

	}
}
