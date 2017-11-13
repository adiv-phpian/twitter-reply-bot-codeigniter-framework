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
class Up_image_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function get_replies(){
		$this->db->select("users.oauth_token, users.oauth_secret, messages.image, files.*, messages.id");
		$this->db->from("messages");
		$this->db->join("files", "files.id = messages.image", "inner");
		$this->db->join("users", "users.user_id = messages.user_id", "inner");
    $this->db->where("messages.is_ready", 0);
		$result = $this->db->get();
		//print_R($result->result());die;
		return $result;
	}

	function update($reply, $response){

		$this->db->where("id", $reply->id);
		$this->db->update("messages",
			                  array("is_ready" => 1,
												      "twitter_media_id" => $response->media_id_string)
											);

	}

}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */
