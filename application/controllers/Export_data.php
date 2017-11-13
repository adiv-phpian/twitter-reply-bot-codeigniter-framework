<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Export_data extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata("user_id")) {
			redirect('/login/');
		}

		ini_set('max_execution_time', 3000000000);
		ini_set('memory_limit','1600M');

	}

	function index()
	{
		  $page = $this->input->post("page");
			$keywords = $this->input->post("keywords");

				if(empty($keywords)){
					echo json_encode(array("code" => 300, "message" => "You must choose atleast one product or all tweets"));
					exit();
				}


      $fields = $this->input->post("export_options");
      if(empty($fields)){
				echo json_encode(array("code" => 300, "message" => "You must choose atleast one field to start export."));
				exit();
      }

      $data['user_id'] = $this->session->userdata("user_id");

			$this->db->where("user_id", $data['user_id']);
			$data['user'] = $this->db->get("users")->row();

      //$data['user'] = $this->users->get_user_by_login($data['user_id']);

      $this->db->where("id", $data['user_id']);
      $this->db->update("users", array("export_options" => json_encode($fields)));

      $this->db->where_in("product_id", $keywords)->limit("10000", $page*10000);
      $this->db->order_by("product_id", "asc");
      $tweets = $this->db->get("tweets");

      if($tweets->num_rows() == 0){
				echo json_encode(array("code" => 300, "message" => "There is no tweet to export, if you added keyword just now, retry after few hours."));
				exit();
      }

      $product_name = false;
      if(in_array("product", $fields)) $product_name = true;

      $user = false;
      if(in_array("user", $fields)) $user = true;

      $profile_description = false;
      if(in_array("profile_description", $fields)) $profile_description = true;

      $datetime = false;
      if(in_array("date", $fields)) $datetime = true;

      $location = false;
      if(in_array("location", $fields)) $location = true;

      $place = false;
      if(in_array("place", $fields)) $place = true;

      $geo = false;
      if(in_array("geo", $fields)) $geo = true;

      $coordinates = false;
      if(in_array("coordinates", $fields)) $coordinates = true;

      $tweet = false;
      if(in_array("tweet", $fields)) $tweet = true;
      $is_retweet = false;
      if(in_array("is_retweet", $fields)) $is_retweet = true;
      $favorited = false;
      if(in_array("favourited", $fields)) $favorited = true;
      $retweet_count = false;
      if(in_array("retweet_count", $fields)) $retweet_count = true;
      $favorite_count = false;
      if(in_array("likes", $fields)) $favorite_count = true;
      $source = false;
      if(in_array("source", $fields)) $source = true;

      $data = array();

      foreach($tweets->result() as $row){

        $row = (array) $row;

				$tweet_json = json_decode($row["tweet_json"]);

				if($product_name) $nestedData["Search keyword"] = $this->clean($row["product_name"]);
        if($user) $nestedData["Full Name"] = $this->clean($tweet_json->user->name);
        if($user) $nestedData["Twitter username"] = $this->clean($tweet_json->user->screen_name);
        if($user) $nestedData["Followers count"] = $tweet_json->user->followers_count;
        if($user) $nestedData["Followings count"] = $tweet_json->user->friends_count;
        if($user) $nestedData["Listed count"] = $tweet_json->user->friends_count;
        if($user) $nestedData["Account created date"] = $tweet_json->user->created_at;
        if($profile_description) $nestedData["Profile description"] = $this->clean($tweet_json->user->description);

        if($tweet) $nestedData["Tweet"] = $this->clean($tweet_json->text);

        if($favorited) $nestedData["Is favorited"] = $tweet_json->favorited ? "Yes" : "No";
        if($is_retweet) $nestedData["Is retweet"] = $tweet_json->retweeted ? "Yes" : "No";

        if($retweet_count) $nestedData["Retweet count"] = $tweet_json->retweet_count;
        if($favorite_count) $nestedData["Favorite count"] = $tweet_json->favorite_count;

        if($location) $nestedData["Location"] = $tweet_json->user->location ? $this->clean($tweet_json->user->location) : ' ';
        if($place) $nestedData["Tweet place"] = $tweet_json->place ? $this->clean($tweet_json->place->full_name) : ' ';
        if($geo) $nestedData["Tweet geo"] = $tweet_json->geo ? implode(" ", $this->clean($tweet_json->geo->coordinates)) : ' ';
        if($coordinates) $nestedData["Tweet coordinates"] = $tweet_json->coordinates ? implode(" ", $this->clean($tweet_json->coordinates->coordinates)) : ' ';

        if($datetime) $nestedData["Tweeted Datetime"] = $row["datetime"];
        if($source) $nestedData["Source"] = $this->clean(strip_tags($tweet_json->source));

        $data[] = $nestedData;
      }

			$count = count($data);

			$keys = array();

			if($page == 0){
				 $keys = array_keys($nestedData);
				 $data = array_merge(array($keys), $data);
      }

			if($this->input->post("export_type") == "csv"){
				 $name = "tweets_export_" . date("Y-m-d") . ".csv";
			}else{
				 $name = "tweets_export_" . date("Y-m-d") . ".xlsx";
			}

			$data = $this->array2csv($data);

      echo json_encode(array("code"=> 200, "page" => $page+1, "count" => $count, "filename" => $name, "data" => $data));
      exit();
	}

	function delete_tweets(){

		$keywords = $this->input->post("keywords");
		if(empty($keywords)){
			echo json_encode(array("code" => 300, "message" => "You must choose atleast one product or all tweets"));
			exit();
		}

		if($this->input->post("delete") && $this->input->post("delete") == 1){
			$this->db->where_in("product_id", $keywords);

			if($this->db->delete("tweets")){
				echo json_encode(array("code"=> 200));
				exit();
			}else{
				echo json_encode(array("code"=> 200, "There is a problem in deleting records, please do it manually."));
				exit();
			}
    }
  }

	private function clean($string){
		return str_replace(";", ":", $string);
	}

	private function array2csv(array &$array)
	{
		 if (count($array) == 0) {
			 return null;
		 }
		 ob_start();
		 $df = fopen("php://output", 'w');
		 //fputcsv($df, array_keys(reset($array)));
		 foreach ($array as $row) {
				fputcsv($df, $row);
		 }

		 fclose($df);

		 return ob_get_clean();
	}

	private function download_send_headers($filename) {
		// disable caching
		$now = gmdate("D, d M Y H:i:s");
		header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
		header("Last-Modified: {$now} GMT");

		// force download
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");

		// disposition / encoding on response body
		header("Content-Disposition: attachment;filename={$filename}");
		header("Content-Transfer-Encoding: binary");
	 }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
