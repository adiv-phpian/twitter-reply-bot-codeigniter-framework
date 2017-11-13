<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public $use_id = "";
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

			$data['title'] = "Dashboard - Tweet Intent";
			$data['base_url'] = base_url();
			$data['asset_url'] = base_url().'assets/';

			$data['user'] = $this->dashboard_model->get_user($this->user_id);

			if(!$data['user']) redirect("/auth/");

		  $option = is_array(json_decode($data['user']->dashboard_options)) ? json_decode($data['user']->dashboard_options) : array();
			$data['dashboard_options'] = $option;

			$data['graph1'] = $this->dashboard_model->get_products_statistics_graph1($this->user_id, $data['dashboard_options']);
      $data['graph2'] = $this->dashboard_model->get_products_statistics_graph2($this->user_id, $data['dashboard_options']);

			//print_R($data['graph2']);die;

			$this->db->where("user_id", $this->user_id);
			$data['products'] = $this->db->get("products");


			$this->load->view('common/before_login_header', $data);
			//$this->load->view('common/header', $data);
			$this->load->view('dashboard', $data);
			$this->load->view('common/before_login_footer', $data);

	}

	function timeline(){

			$this->load->model("tc_model");
			$data['title'] = "Dashboard - Tweet Intent";
			$data['base_url'] = base_url();
			$data['asset_url'] = base_url().'assets/';

			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username'] = $this->tank_auth->get_username();
			$data['user'] = $this->users->get_user_by_login($this->tank_auth->get_username());

      $this->db->where("user_id", $this->tank_auth->get_user_id());
			$this->db->order_by("added_date", "desc");
			$products_db = $this->db->get("products");

			$dashboard_options = is_array(json_decode($data['user']->dashboard_options)) ? json_decode($data['user']->dashboard_options) : array();


			$products = array();
      $i = 0;
			foreach($products_db->result() as $product) {
				$i = $i+1;

				if(!in_array($product->product_name, $dashboard_options)) continue;
	      $data['product'] = $this->tc_model->get_product_count($product->id);
				$data['product_stat'] = $this->tc_model->get_product_stat($product->id);

				$products[$i]['name'] = $product->product_name;
				$products[$i]['points'] = '[]';

				if($data['product_stat']->num_rows() > 0){

				$stat = $data['product_stat']->row();

				$tweets_counts = explode(", ", $stat->tweet_count);
				$tweets_datetime = explode(", ", $stat->tweet_datetime);

				$points = "[";

				
				foreach($tweets_counts as $key => $val){
					$date = date("Y,m,d", strtotime("-1 months", strtotime($tweets_datetime[$key])));
					$points .= "[Date.UTC($date), $val],";
				}

				$points .= "]";

				$tweets_counts = explode(", ", $stat->oral_count);
				$tweets_datetime = explode(", ", $stat->oral_datetime);

	      $products[$i]['points'] = $points;

				}
		 }
        $data['products_stat'] = $products;
        $this->load->view('timeline', $data);

	}

	function save_graph_options(){
    $data = $this->input->post("dashboard_options");
    $data1['dashboard_options'] = json_encode($data);
    $this->db->where("user_id", $this->session->userdata("user_id"));

		if($this->db->update("users", $data1)){
			echo json_encode(array("code" => 200));
		}else{
      echo json_encode(array("code" => 400));
		}

	}

	function save_table_options(){
    $data = $this->input->post("table_options");
    $data1['table_options'] = json_encode($data);
    $this->db->where("user_id", $this->session->userdata("user_id"));

		if($this->db->update("users", $data1)){
			echo json_encode(array("code" => 200));
		}else{
      echo json_encode(array("code" => 400));
		}

	}

	function delete_all_tweets($id = 0){
		if($id > 0) $this->db->where("product_id", $id);
    $this->db->where("user_id", $this->session->userdata("user_id"));

		if($this->db->delete("tweets")){
			//print_R($this->db->last_query());die;
			echo json_encode(array("code" => 200));
		}else{
      echo json_encode(array("code" => 400));
		}

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
