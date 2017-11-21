<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{
	protected $twitter_paramateres = array();
	public $settings = array();
	public $page = "";
	private $user_id;

	function __construct()
	{
		parent::__construct();

		$this->data['asset_url'] = str_replace("index.php/", "", base_url()).'assets/';

    $this->load->library("OAuth");
		$this->load->model("auth_model");
		$this->twitter_paramateres = array('consumer_key' => $this->config->item("twitter_consumer_key"),
											                 'consumer_secret' => $this->config->item("twitter_consumer_secret"),
											                 'callback_url' => base_url().'auth/twitter_response');
	}

	public function index()
	{
		if ($this->session->userdata("user_id")) {
				redirect('/dashboard/');
		}

    $this->data['title'] = "Login with Twitter - ";
    $this->load->view("site/login", $this->data);
  }

	/**
	 * Functionalities for twitter and instagram
	 */
	public function login($option = "")
	{
		$options = array();
    $this->load->view("errors/success", array("heading" => "Twitter Authorization", "message" => "Going to twitter to connect with your account."));

		if($this->input->get("force_login")){
			 $options['force_login'] = "true";
		}

    redirect($this->oauth->login($this->twitter_paramateres, $options));
	}


	public function twitter_response()
	{
    try {

			if($this->input->get("denied")) redirect(base_url());

	    if(!$this->input->get("oauth_verifier") || !$this->input->get("oauth_token")) throw new Exception("Authorization not successful.");

		  $access_token = $this->oauth->twitter_callback($this->twitter_paramateres, $this->input->get());

	    $data = array('user_id' => $access_token['id_str'],
										'oauth_token' => $access_token['oauth_token'],
	                  'oauth_secret' => $access_token['oauth_token_secret'],
									  "user_json" => json_encode($access_token),
										"last_login" => date("Y-m-d H:i:s")
									  );


			$type = "single";
			$user_id = $access_token['id_str'];

      $this->db->where("user_id", $access_token['id_str']);
			$this->db->from("users");
			$acct = $this->db->get();

      if($acct->num_rows() > 0){
         $this->db->where("user_id", $access_token['id_str']);
         $this->db->update("users", $data);
      }else{
				 $data['created'] = date("Y-m-d H:i:s");
         $this->db->where("user_id", $access_token['id_str']);
         $this->db->insert("users", $data);
      }


			$array = array("status" => "1",
		                 "user_id" => $user_id,
									   "type" => $type);

			$this->session->set_userdata($array);

			redirect(base_url());

    }catch (Exception $e) {
      $this->load->view("errors/custom", array("heading" => "Twitter Authorization", "message" => $e->getMessage()));
    }

  }

	public function logout()
	{
    $this->session->unset_userdata("status");
		$this->session->unset_userdata("user_id");
		$this->session->unset_userdata("type");
		$this->session->sess_destroy();
		redirect(base_url());
  }

	public function json(){

	}
 }

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
