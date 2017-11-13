<?php

require "twitteroauth-master/vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

class Up_image_lib {

    public static function connect($attr){
      if(is_object($attr)) $attr = (array) $attr;
      return new TwitterOAuth($attr['consumer_key'], $attr['consumer_secret'], $attr['oauth_token'], $attr['oauth_token_secret']);
    }

    public static function upload($conn, $media){
      return $conn->uploadMediaNotChunked("media/upload", array("media" => $media));
    }

  }
?>
