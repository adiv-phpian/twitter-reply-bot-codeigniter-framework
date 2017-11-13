<?php

 require_once('twitteroauth-master/TwitterAPIExchange.php'); 

class Twitter_lib {

  public static function get_tweets($settings, $str, $refresh_url){
    $str = str_replace(",", "+", $str);
    $hashtag = explode("#", $str);
    $screen_name = explode("@", $str);

    $url = "https://api.twitter.com/1.1/search/tweets.json";
 		$requestMethod = "GET";
    if($refresh_url != "0"){
     $getfield = $refresh_url;
    }else{
 		 $getfield = '?q=#'.$str.'&count=5&result_type=recent';
    }

       $twitter = new TwitterAPIExchange($settings);
       $string = $twitter->setGetfield($getfield)
       ->buildOauth($url, $requestMethod)
       ->performRequest();
  		 $var = rtrim($string, "\0");
  		 $string = json_decode($var, true);

       return $string;
  }

  public static function get_statuses($settings, $screen_name, $id){

    $url = "https://api.twitter.com/1.1/search/tweets.json";
    $requestMethod = "GET";
    $getfield = '?q=to:'.$screen_name.'&since_id='.$id;
    //$getfield = '?q=to:ShawnMcCool&since_id=753121818714730499&result_type=recent';

    $twitter = new TwitterAPIExchange($settings);
    $string = $twitter->setGetfield($getfield)
       ->buildOauth($url, $requestMethod)
       ->performRequest();
       $var = rtrim($string, "\0");
       $string = json_decode($var, true);

       return $string;
  }


  public static function get_favourites($settings, $screen_name, $id){

    $url = "https://api.twitter.com/1.1/favorites/list.json";
    $requestMethod = "GET";
    //$getfield = '?screen_name='.$screen_name.'&since_id='.$id.'&include_entities=1';
    $getfield = '?screen_name=divangessen';//753121818714730499&since_id=753193362312814593';//&since_id='.$id.'&include_entities=1';

    $twitter = new TwitterAPIExchange($settings);
    $string = $twitter->setGetfield($getfield)
       ->buildOauth($url, $requestMethod)
       ->performRequest();
       $var = rtrim($string, "\0");
       $string = json_decode($var, true);
       print_r($string);die;
       return $string;
  }

  public static function get_user($settings){
    $url = "https://api.twitter.com/1.1/account/verify_credentials.json";
    $requestMethod = "GET";
    $twitter = new TwitterAPIExchange($settings);
    $string = $twitter->buildOauth($url, $requestMethod)->performRequest();
    $var = rtrim($string, "\0");
    return json_decode($var, true);
  }

  public static function get_friends_ids($settings, $ids = array(), $next_cursor = "1"){

    $url = "https://api.twitter.com/1.1/friends/ids.json";
    $requestMethod = "GET";

    while($next_cursor){
     $twitter = new TwitterAPIExchange($settings);
     $getfield = '?screen_name='.$settings['screen_name'].'&count=5000&stringify_ids=true';
     if($next_cursor > "1") $getfield .= '&cursor='.$next_cursor;
     $string = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
     $var = rtrim($string, "\0");
     $friends = json_decode($var, true);

     if(!isset($friends['ids'])) self::error_handling_twitter($settings, $friends, "friends", "/friends/ids");

     $ids = array_merge($ids, $friends['ids']);
     $next_cursor = $friends['next_cursor_str'];
    }
    return $ids;
  }

  public static function get_rate_limit($settings){
    $url = "https://api.twitter.com/1.1/application/rate_limit_status.json";
    $requestMethod = "GET";

    $twitter = new TwitterAPIExchange($settings);
    $string = $twitter->buildOauth($url, $requestMethod)->performRequest();
    $var = rtrim($string, "\0");
    return json_decode($var, true);
  }

  public static function get_followers_ids($settings, $ids = array(), $next_cursor = "1"){

    $url = "https://api.twitter.com/1.1/followers/ids.json";
    $requestMethod = "GET";

    while($next_cursor){
     $twitter = new TwitterAPIExchange($settings);
     $getfield = '?screen_name='.$settings['screen_name'].'&count=5000&stringify_ids=true';
     if($next_cursor > "1") $getfield .= '&cursor='.$next_cursor;
     $string = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
     $var = rtrim($string, "\0");
     $followers = json_decode($var, true);

     if(!isset($followers['ids'])) self::error_handling_twitter($settings, $followers, "followers", "/followers/ids");

     $ids = array_merge($ids, $followers['ids']);
     $next_cursor = $followers['next_cursor_str'];
    }

    return $ids;
  }

  public static function error_handling_twitter($settings, $response, $category, $cate){
    $message = $response['errors']['0']['message'];
    $code = $response['errors']['0']['code'];
    if($code == "88"){
      $code = self::get_rate_limit($settings);
      $response = $code['resources'][$category][$cate];

      $message .= "<br>Next available request time : ". date('Y/m/d H:i:s', $response['reset']);
      $message .= "<br> Remaining Limit : ".$response['remaining'];
      $message .= "<br>Total Limits : ". $response['limit'];
    }
    echo json_encode(array("code" => "501", "message" => $message));die;
  }


  public static function get_unfollowers($settings, $page="0"){

       try {
          $friends = self::get_friends_ids($settings);
          $followers = self::get_followers_ids($settings);
        }catch (Exception $e){
          throw new Exception($e->getMessage());
        }


      $twitter = new TwitterAPIExchange($settings);

      $unfollowers_id = array_diff($friends, $followers);
      $ids_arrays = array_chunk($unfollowers_id, 100, true);

      $i=1;
      $profiles = array();
       foreach($ids_arrays as $implode) {
           $user_ids=implode(',', $implode);
           $url = "https://api.twitter.com/1.1/users/lookup.json";
           $requestMethod = "GET";
           $getfield = "?user_id=$user_ids";

           $string = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
           $var = rtrim($string, "\0");
           $results = json_decode($var, true);
           //print_r($results);die;
           foreach($results as $key => $profile) {
               $k = array_search($profile['id'], $implode);
               $profiles[$k] = $profile;
           }
       }

     return $profiles;
  }


  public static function get_unfollowers_list($settings){
      $twitter = new TwitterAPIExchange($settings);
      $friends = self::get_friends_ids($settings);
      $followers = self::get_followers_ids($settings);
      $unfollowers_id = array_filter(array_diff($friends, $followers));
      $ids_arrays = array_chunk($unfollowers_id, 100, true);

      $i=1;
      $profiles = array();
       foreach($ids_arrays as $implode) {
           $user_ids = implode(',', $implode);
           $url = "https://api.twitter.com/1.1/users/lookup.json";
           $requestMethod = "GET";
           $getfield = "?user_id=$user_ids";

           $string = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
           $var = rtrim($string, "\0");
           $results = json_decode($var, true);

           if(isset($results['errors'])) error_handling_twitter($settings, $results, "users", "/users/lookup");

           foreach($results as $key => $profile) {
               $k = array_search($profile['id'], $implode);
               $profiles[$k] = $profile;
           }
       }

     return $profiles;
  }

  public static function get_followers_list($settings){
      $twitter = new TwitterAPIExchange($settings);
      $friends = self::get_friends_ids($settings);
      $followers = self::get_followers_ids($settings);
      $unfollowers_id = array_filter(array_diff($followers, $friends));
      $ids_arrays = array_chunk($unfollowers_id, 100, true);

      $i=1;
      $profiles = array();
       foreach($ids_arrays as $implode) {
           $user_ids = implode(',', $implode);
           $url = "https://api.twitter.com/1.1/users/lookup.json";
           $requestMethod = "GET";
           $getfield = "?user_id=$user_ids";

           $string = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
           $var = rtrim($string, "\0");
           $results = json_decode($var, true);

           if(isset($results['errors'])) error_handling_twitter($settings, $results, "users", "/users/lookup");

           foreach($results as $key => $profile) {
               $k = array_search($profile['id'], $implode);
               $profiles[$k] = $profile;
           }
       }

     return $profiles;
  }

  public static function get_users_pofile($settings, $ids, $ids_main){

      $twitter = new TwitterAPIExchange($settings);

      $i=1;
      $profiles = array();
      $ids_uni = array_column($ids, "id");
      $user_ids = implode(',', $ids_uni);
      $url = "https://api.twitter.com/1.1/users/lookup.json";
      $requestMethod = "GET";
      $getfield = "?user_id=$user_ids";

      $string = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
      $var = rtrim($string, "\0");
      $results = json_decode($var, true);

      foreach($results as $key => $profile) {
               $k = $ids_main[$profile['id']];
               $profile['main_id'] = $k;
               $profiles[] = $profile;
      }


     return $profiles;
  }

  public static function unfollow($settings, $user_id){

     $url = "https://api.twitter.com/1.1/friendships/destroy.json";
     $requestMethod = "POST";
     $postfield = array("user_id" => $user_id);

     $twitter = new TwitterAPIExchange($settings);
     $string = $twitter->setPostfields($postfield)->buildOauth($url, $requestMethod)->performRequest();
     $var = rtrim($string, "\0");
     $response = json_decode($var, true);

    return $response;
 }

 public static function follow($settings, $user_id){

    $url = "https://api.twitter.com/1.1/friendships/create.json";
    $requestMethod = "POST";
    $postfield = array("user_id" => $user_id, "follow" => "true");

    $twitter = new TwitterAPIExchange($settings);
    $string = $twitter->setPostfields($postfield)->buildOauth($url, $requestMethod)->performRequest();
    $var = rtrim($string, "\0");
    $response = json_decode($var, true);

   return $response;
 }
}
?>
