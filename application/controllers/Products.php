<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller
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
      $data['title'] = "Products - Tweet bot";
			$data['base_url'] = base_url();
			$data['asset_url'] = base_url().'assets/';

			$data['user'] = $this->dashboard_model->get_user($this->user_id);

      $this->load->view('common/before_login_header', $data);
			//$this->load->view('common/header', $data);
			$this->load->view('products', $data);
			$this->load->view('common/before_login_footer', $data);

	}

	function data(){
    if(isset($_POST['action']) && $_POST['action'] == "create"){
		 $_REQUEST['data']['0']['added_date'] = date("Y-m-d H:i:s");
		 $_POST['data']['0']['added_date'] = date("Y-m-d H:i:s");
	  }

		if(isset($_POST['action']) && ($_POST['action'] == "create" || $_POST['action'] == "update")){

			$this->db->where("product_name", $this->input->post("data")['0']['product_name']);
			$this->db->where("user_id", $this->user_id);
			$products = $this->db->get("products");

			if($products->num_rows() > 0){
				$res =  json_decode(json_encode(array("0" => array("name" => "product_name", "status" => "Keyword already added.")), FALSE));
				//print_R($res);die;
				echo json_encode(array("fieldErrors" =>  $res));
				exit();
			}
	 }

	 $this->load->library("datatables");
	 $this->datatables->get_motors($this->user_id);
 }

	function tweets($type, $id){
		$id = urldecode($id);

    $this->load->model("tc_model");

 		$data['title'] = "Products - Tweet Intent";
 		$data['base_url'] = base_url();
 		$data['asset_url'] = base_url().'assets/';
		$data['type'] = $type;
		$data['id'] = $id;

		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username'] = $this->tank_auth->get_username();
		$data['user'] = $this->users->get_user_by_login($this->tank_auth->get_username());

 		$data['product'] = $this->tc_model->check_access($id);

		$option = is_array(json_decode($data['user']->table_options)) ? json_decode($data['user']->table_options) : array();
		$data['table_options'] = $option;

		$option = is_array(json_decode($data['user']->export_options)) ? json_decode($data['user']->export_options) : array();
		$data['export_options'] = $option;

		$this->db->where("user_id", $this->tank_auth->get_user_id());
		$data['products'] = $this->db->get("products");


		$this->load->view('common/before_login_header', $data);
		//$this->load->view('common/header', $data);
		$this->load->view("products_tweets_detail", $data);
		$this->load->view('common/before_login_footer', $data);
  }

	function tweets_data(){
		$type = $this->input->get("type");
		$id = $this->input->get("id");
		$this->load->model("tc_model");
		$this->load->library("datatables");
		$product = $this->tc_model->check_access($id);
		$this->datatables->get_tweets_by_cate($type, $product, $this->tank_auth->get_user_id());
	}

	function product($id = 0){

		$id = urldecode($id);

    $this->load->model("tc_model");

		$data['title'] = "Products - Tweet Intent";
		$data['base_url'] = base_url();
		$data['asset_url'] = base_url().'assets/';

		$product = $this->tc_model->check_access($id);

		$data['product'] = $this->tc_model->get_product_count($product->id);
		$data['product_stat'] = $this->tc_model->get_product_stat($product->id);

		if($data['product_stat']->num_rows() > 0){

    $stat = $data['product_stat']->row();

		$tweets_counts = explode(", ", $stat->tweet_count);
		$tweets_datetime = explode(", ", $stat->tweet_datetime);

		$points = "[";
    foreach($tweets_counts as $key => $val){
			$date = date("Y,m,d", strtotime("-1 month", $tweets_datetime[$key]));
			$points .= "[Date.UTC($date), $val],";
		}

		$points .= "]";

		$tweets_counts = explode(", ", $stat->oral_count);
		$tweets_datetime = explode(", ", $stat->oral_datetime);

		$points1 = "[";
    foreach($tweets_counts as $key => $val){
			$date = date("Y,m,d", strtotime("-1 month", $tweets_datetime[$key]));
			$points1 .= "[Date.UTC($date), $val],";
		}

		$points1 .= "]";


		$tweets_counts = explode(", ", $stat->perfect_count);
		$tweets_datetime = explode(", ", $stat->perfect_datetime);

		$points2 = "[";
    foreach($tweets_counts as $key => $val){
			$date = @date("Y,m,d", strtotime("-1 month", $tweets_datetime[$key]));
			$points2 .= "[Date.UTC($date), $val],";
		}

		$points2 .= "]";

		$data['points'] = $points;
		$data['points1'] = $points1;
		$data['points2'] = $points2;

	  }

		$this->load->view('common/before_login_header', $data);
		//$this->load->view('common/header', $data);
		$this->load->view('products_detail', $data);
		$this->load->view('common/before_login_footer', $data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
