<?php

require "twitteroauth-master/vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

class Reply_lib {

    public static function connect($attr){
      if(is_object($attr)) $attr = (array) $attr;
      return new TwitterOAuth($attr['consumer_key'], $attr['consumer_secret'], $attr['oauth_token'], $attr['oauth_token_secret']);
    }

    public static function reply($conn, $tweet, $media_id, $reply){

      $query = array("status" => $reply,
                     "in_reply_to_status_id" => $tweet->tweet_id
                     );
      if($media_id != NULL && $media_id != 0) $query['media_ids'] = $media_id;


      return $conn->post("statuses/update", $query);
    }

  }
?>
