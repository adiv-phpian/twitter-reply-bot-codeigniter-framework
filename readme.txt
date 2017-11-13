
1. Export the zip file to the location where do you want to install this script on your server.
   
   
2. create database on your mysql server, Find sql.sql inside zip folder and import to mysql using phpmyadmin or command line.

3. Open configuration file /application/config/config.php

   -> On line 26 Change the base_url to your site url.

   $config['base_url'] = 'http://localhost/upwork/chris_abbott/app/';

   -> on line 28 replace following consumer key and secret with your twitter keys.

   $config['twitter_consumer_key'] = 'NHESUytav9t5GKZnM5BsI3wxE';
   $config['twitter_consumer_secret'] = 'S3kmginlQiVikkoPKq5UcNf1QFTOAdjayhqQNll9r0N0DkPIII';

4. Open database configuration /application/config/database.php
   
   => on line 79 replace username, password and database name.

   'username' => 'root',
   'password' => '',
   'database' => 'upwork_twitter_reply_bot',


Once all setup, you can test the script by running it on browser. 

   
