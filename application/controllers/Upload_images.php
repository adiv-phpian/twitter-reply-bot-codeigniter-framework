<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload_images extends CI_Controller
{

	public $count;
	public $method;

	function __construct()
	{
		parent::__construct();
		$this->load->library("up_image_lib");
		$this->load->model("up_image_model");

		$this->count = 0;
		$this->method = "";

		$this->settings = array('consumer_key' => $this->config->item("twitter_consumer_key"),
                            'consumer_secret' => $this->config->item("twitter_consumer_secret"));
	}

	function index(){

		$replies = $this->up_image_model->get_replies();

		foreach($replies->result() as $reply){
			$this->check_and_update_reply($reply);
		}

	}


	private function check_and_update_reply($reply){

		$this->settings['oauth_token'] = $reply->oauth_token;
		$this->settings['oauth_token_secret'] = $reply->oauth_secret;

		$con = $this->up_image_lib->connect($this->settings);
		$response = $this->up_image_lib->upload($con, $reply->system_path);

		$this->up_image_model->update($reply, $response);
	}


}
