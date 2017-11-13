<?php

 class Auth_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct(){
        parent::__construct();
    }

    function get_user($user_id){
      $this->db->where("user_id", $user_id);
      $user = $this->db->get("users");

      if($user->num_rows() == 1){
       return $this->db->get("users")->row();
      }else{
       return false;
     }
 	 }
 }

?>
