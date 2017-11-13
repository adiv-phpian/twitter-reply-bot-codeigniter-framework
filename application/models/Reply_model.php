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
class Reply_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function get_tweets(){
		$this->db->select("users.oauth_token, tweets.tweet_json, tweets.id as t_id, users.oauth_secret, tweets.id, tweets.user_id, tweets.tweet_id, products.id as product_id");
		$this->db->from("tweets");
		$this->db->join("users", "users.user_id = tweets.user_id", "inner");
		$this->db->join("products", "products.id = tweets.product_id", "inner");
		//$this->db->join("messages", "messages.search_id = products.id", "inner");
    $this->db->where("tweets.is_new", 1);
		//$this->db->or_where("messages.image", NULL);

    /*$this->db->where("users.reply_reset < ", date("Y-m-d H:i:s"));*/
		$this->db->where("users.last_reply_time < ", date("Y-m-d H:i:s"));
    //$this->db->order_by("rand()");
		$this->db->order_by("tweets.added_date", "asc")->limit("5");
		$result = $this->db->get();
		//print_R($result->result());die;
		return $result;
	}

	function get_rand_message($id){
		$this->db->select("messages.id, messages.twitter_media_id, messages.reply");
		$this->db->where("messages.search_id", $id);
		$this->db->where("messages.is_ready", 1);
		//$this->db->or_where("messages.image", NULL);
		$this->db->order_by("rand()");
		$this->db->limit("1");
		return $this->db->get("messages");
	}

	function update_reply($user_id, $tweet_id, $id){
		$this->db->where("id", $tweet_id);
		$this->db->update("tweets", array("message_id" => $id, "is_new" => 0));

		$val = rand("2", "5");

		$this->db->where("user_id", $user_id);
		$this->db->update("users", array("last_reply_time" => date("Y-m-d H:i:s", strtotime("+$val minutes"))));
	}

	function update_delay($tweet_id){
		$this->db->where("id", $tweet_id);
		$this->db->update("tweets", array("added_date" => date("Y-m-d H:i:s")));
	}

	function get_messages($ids = 0){
		if($ids != 0) $this->db->where_in("id", $ids);
		$this->db->where_in("user_id", $this->session->userdata("user_id"));
		return $this->db->get("messages");
	}

	function get_search(){
		$this->db->where_in("user_id", $this->session->userdata("user_id"));
		return $this->db->get("products");
	}

	function update_replies($tweet, $reply, $stage, $type = 0){

		//print_R($reply);die("0000000000");

		$tweet_user_id = json_decode($tweet->tweet_json)->user->id_str;

			$data = array("main_tweet_id" => $tweet->tweet_id,
		                "last_tweet_id" => $reply->id_str,
									  "status" => json_encode($reply),
									  "stage" => $stage,
									  "user_id" => $tweet->user_id,
									  "tweet_user_id" => $tweet_user_id);

			$this->db->insert("replies", $data);

			$this->db->where("tweet_id", $tweet->tweet_id);
			$this->db->update("tweets",
			                  array("is_new" => $type+1,
												      "reply_time" => date("Y-m-d H:i:s"))
												);

	}

	function update_reset_time($user_id){
		$this->db->where("user_id", $user_id);
		$this->db->update("users", array("reply_reset" => date("Y-m-d H:i:s", strtotime("+15 minutes"))));
	}
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */
