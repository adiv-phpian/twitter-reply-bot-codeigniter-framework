<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/login/');
		}

		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->model('free_agent_model');

		$this->user_id	= $this->tank_auth->get_user_id();
		$this->username	= $this->tank_auth->get_username();
	}

	function index(){
		$data['user'] = $this->users->get_user_by_login($this->username);
    //$data['account'] = $this->free_agent_model->get_user_fa_details($this->user_id);

		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

		$data['errors'] = array();

		if ($this->form_validation->run()) {								// validation ok
			if ($this->tank_auth->change_password(
					$this->form_validation->set_value('old_password'),
					$this->form_validation->set_value('new_password'))) {	// success
				$this->_show_message($this->lang->line('auth_message_password_changed'));

			} else {														// fail
				$errors = $this->tank_auth->get_error_message();
				foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
			}
		}

		    $data['title'] = "Settings - Exportify";
				$data['base_url'] = base_url();
				$this->data['asset_url'] = str_replace("index.php/", "", base_url()).'assets/';

				$this->load->view('common/before_login_header', $data);

        $this->load->view('settings', $data);
				$this->load->view('common/before_login_footer', $data);

	}

	function cancel_subscription(){

    $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		$data['errors'] = array();

		if ($this->form_validation->run()) {								// validation ok

						$this->db->where("user_id", $this->user_id);
						$result = $this->db->get("subscriptions");

						if($result->num_rows() > 0){
						 $this->remove_subscription($result->row()->subscription_id);
						}

           $this->db->where("id", $this->user_id);
					 $key = $this->db->get("users")->row()->download_key;

			if ($this->tank_auth->delete_user(
					$this->form_validation->set_value('password'))) {		// success

					if($key != "" && $key != NULL) $this->remove_user_datas($key);

					$this->session->set_flashdata("message", "Your account successfully deleted.");

					redirect('/auth');

			} else {														// fail
				$errors = $this->tank_auth->get_error_message();
				foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
			}
		}
		$this->load->view('cancel_subscription', $data);
	}

	/**
	 * Show info message
	 *
	 * @param	string
	 * @return	void
	 */
	function _show_message($message)
	{
		$this->session->set_flashdata('message', $message);
		redirect('/settings/');
	}

	/**
	 * Remove user datas
	 *
	 * @param	string
	 * @return	void
	 */
	private function remove_user_datas($key){
		if(is_dir("fa_zz_datas/".$key."/")){
		 $this->delete_files("fa_zz_datas/".$key."/");
	  }
		 $this->free_agent_model->remove_user_datas($this->user_id);
	}

	private function delete_files($src) {
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            $full = $src . '/' . $file;
            if ( is_dir($full) ) {
                $this->delete_files($full);
            }
            else {
								chmod($full,0777);
                unlink(realpath($full));
            }
        }
    }
    closedir($dir);
    rmdir(realpath($src));
  }

	private function remove_subscription($subscription_id){
		$data = array(
					 'vendor_id'      => $this->config->item("paddle_vendor_id"),
					 'vendor_auth_code' => $this->config->item("paddle_vendor_auth_code"),
					 'subscription_id'    => $subscription_id
	 );

	 $data_string = json_encode($data);

	 $curl = curl_init('https://vendors.paddle.com/api/2.0/subscription/users_cancel');

	 curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");

	 curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	 'Content-Type: application/json',
	 'Content-Length: ' . strlen($data_string))
	 );

	 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
	 curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);  // Insert the data

	 // Send the request
	 $result = json_decode(curl_exec($curl));

	 // Free up the resources $curl is using
	 curl_close($curl);
   //print_r($result);die;
	 if($result->success == 1){

	 }else{
      $this->session->set_flashdata("fail_delete", "Something wrong on payment unsubscription, Try after some time.");
			redirect('/settings/cancel_subscription');
	 }

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
