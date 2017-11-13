<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reply extends CI_Controller
{

	public $count;
	public $method;

	function __construct()
	{
		parent::__construct();
		$this->load->library("reply_lib");
		$this->load->model("reply_model");

		$this->count = 0;
		$this->method = "";

		$this->settings = array('consumer_key' => $this->config->item("twitter_consumer_key"),
                            'consumer_secret' => $this->config->item("twitter_consumer_secret"));
	}

	function index(){

		if(date("H") < 6 || date("H") > 18) die("timeout");

		$tweets = $this->reply_model->get_tweets();

		foreach($tweets->result() as $tweet){
			$id = 0;
			$message = $this->reply_model->get_rand_message($tweet->product_id);

			if($message->num_rows() > 0){
				 $message = $message->row();
				 $id = $message->id;
				 $i = $this->reply_for_tweet($tweet, $message);

				 $this->reply_model->update_reply($tweet->user_id, $tweet->t_id, $id);
			 }else{
				 $this->reply_model->update_delay($tweet->t_id);
			 }
		}

	}


	private function reply_for_tweet($tweet, $message){

		$user_name = json_decode($tweet->tweet_json)->user->screen_name;
		$reply = "@$user_name ". $message->reply;
		return $this->reply_tweet($tweet, $message->twitter_media_id, $reply);

  }

	private function reply_tweet($tweet, $media_id, $reply){

		$this->settings['oauth_token'] = $tweet->oauth_token;
		$this->settings['oauth_token_secret'] = $tweet->oauth_secret;

    sleep(rand("4", "7"));

		$con = $this->reply_lib->connect($this->settings);
		$reply = $this->reply_lib->reply($con, $tweet, $media_id, $reply);

			if(isset($reply->errors)){
			 $this->reply_model->update_reset_time($tweet->user_id);
       exit();
			}else{
				return $reply;
			}
	}

}
