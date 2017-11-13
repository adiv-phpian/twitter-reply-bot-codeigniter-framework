<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tweets extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata("user_id")) {
			redirect('/auth/');
    }

		$this->load->model(array("dashboard_model", "tc_model"));
		$this->user_id = $this->session->userdata("user_id");

	}

	function index()
	{
			$data['title'] = "Apps - Tweets";
			$data['base_url'] = base_url();
			$data['asset_url'] = base_url().'assets/';

			$data['user_id'] = $this->user_id;
			$data['user'] = $this->dashboard_model->get_user($this->user_id);

			$option = is_array(json_decode($data['user']->table_options)) ? json_decode($data['user']->table_options) : array();
      $data['table_options'] = $option;

			$option = is_array(json_decode($data['user']->export_options)) ? json_decode($data['user']->export_options) : array();
      $data['export_options'] = $option;

			$this->db->where("user_id", $this->user_id);
			$data['products'] = $this->db->get("products");

      $this->load->view('common/before_login_header', $data);
			//$this->load->view('common/header', $data);
			$this->load->view('tweets', $data);
			$this->load->view('common/before_login_footer', $data);

	}

	function data(){
    $this->load->library("datatables");
		$this->datatables->get_tweets($this->user_id);
 }

 function tweet(){
	 if(!$this->input->get("id")) return;

	 $id = $this->input->get("id");

	 $this->db->select("tweets.*, messages.*");
	 $this->db->from("tweets");
	 $this->db->join("messages", "messages.id = tweets.message_id", "left");
	 $this->db->where(array("tweets.id" => $id, "tweets.user_id" => $this->session->userdata("user_id")));
	 $tweets = $this->db->get();

	 if($tweets->num_rows() == "0"){
		 echo json_encode(array("code" => "200", "html" => "<h3>Tweet Not Found, Please try again.</h3>"));
		 return;
	 }

	 $tweet = $tweets->row();

	 $html = $this->load->view("view_tweet", array("tweet" => $tweet), true);

	 echo json_encode(array("code" => "200", "html" => $html));

 }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
