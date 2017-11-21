<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Replies extends CI_Controller
{


	function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata("user_id")) {
			redirect('/auth/');
    }

		$this->load->model(array("dashboard_model", "reply_model"));
		$this->user_id = $this->session->userdata("user_id");

	}

	function index()
	{
			$data['title'] = "Replies";
			$data['base_url'] = base_url();
			$this->data['asset_url'] = str_replace("index.php/", "", base_url()).'assets/';

			$data['user_id'] = $this->user_id;
			$data['user'] = $this->dashboard_model->get_user($this->user_id);
			$data['search'] = $this->reply_model->get_search()->result();

      $this->load->view('common/before_login_header', $data);
			//$this->load->view('common/header', $data);
			$this->load->view('replies', $data);
			$this->load->view('common/before_login_footer', $data);
	}

	function data(){
		$image = 0;

		if(isset($_POST['action']) && ($_POST['action'] == "create" || $_POST['action'] == "edit")){

		 foreach($_POST['data'] as $key => $data){
			if(strlen($data['reply']) > 280){
				$res =  json_decode(json_encode(array("0" => array("name" => "reply", "status" => "Maximum number of character exceeded")), FALSE));
				//print_R($res);die;
				echo json_encode(array("fieldErrors" =>  $res));
				exit();
			}

			$image = $data['image'] ? 0 : 1;
		 }

		}

    $this->load->library("datatables");
		$this->datatables->get_replies($this->user_id, $image);
 }

 function get(){
	 $data_o = $this->reply_model->get_search();

   echo json_encode(array("data" => $data_o->result_array()));
 }

 function tweet(){
	 if(!$this->input->get("id")) return;

	 $id = $this->input->get("id");

	 $this->db->where(array("id" => $id, "user_id" => $this->session->userdata("user_id")));
	 $tweet = $this->db->get("tweets");

	 if($tweet->num_rows() == "0"){
		 echo json_encode(array("code" => "200", "html" => "<h3>Tweet Not Found, Please try again.</h3>"));
		 return;
	 }

	 $html = $this->load->view("view_tweet", array("tweet" => $tweet->row()), true);

	 echo json_encode(array("code" => "200", "html" => $html));

 }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
