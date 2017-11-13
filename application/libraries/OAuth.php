<?php

require "twitteroauth-master/lib/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

class OAuth {

    public static function connect($attr){
      if(is_object($attr)) $attr = (array) $attr;
      return new TwitterOAuth($attr['consumer_key'], $attr['consumer_secret'], $attr['oauth_token'], $attr['oauth_token_secret']);
    }

    public static function get_user($conn){
      return $conn->get("account/verify_credentials");
    }

    public function login($attr, $options = array()){
      $connection = new TwitterOAuth($attr['consumer_key'], $attr['consumer_secret']);

      $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => $attr['callback_url']));
      $_SESSION['oauth_token'] = $request_token['oauth_token'];
      $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

      $parameters = array('oauth_token' => $request_token['oauth_token']);
      //if($screen_name != "") $parameters['screen_name'] = $screen_name;
       $ourl = "";
      foreach($options as $key => $value){
        $ourl .= $key.'='.$value.'&';
      }

      return $connection->url('oauth/authorize', $parameters).'&'.$ourl;
    }

    public static function search($conn, $product, $method = "refresh"){

    $search = $product->product_name;

    $query = array("q" => $search .' AND -filter:retweets AND -filter:replies',
                   "count" => "10"
                   );

    if($method == "refresh" && $product->since_id != 0){
       $query['since_id'] = $product->since_id;
     }

    if($method == "next" && $product->max_id != 0){
       $query['max_id'] = $product->max_id;
    }

    $search = $conn->get("search/tweets", $query);
    return $search;
   }


    public static function twitter_callback($attr, $request = array()){

      $request_token = [];
      $request_token['oauth_token'] = $_SESSION['oauth_token'];
      $request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

      if (isset($request['oauth_token']) && $request_token['oauth_token'] !== $request['oauth_token']) {
          $response['error'] = "1";
          return false;
      }

      $connection = new TwitterOAuth($attr['consumer_key'], $attr['consumer_secret'], $request_token['oauth_token'], $request_token['oauth_token_secret']);
      $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $request['oauth_verifier']]);

      $connection = self::connect(array_merge($attr, $access_token));

      return array_merge((array) self::get_user($connection), $access_token);
   }


  }
?>
