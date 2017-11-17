<?php $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<html>
<style>
form{
	margin: 0 auto;

}
table{
	margin: 0 auto;
	margin-top: 15%;
}
</style>

<table>

<?php

$error = 0;

if(isset($_POST['database'])){
  $servername = $_POST['host'];
	$database = $_POST['database'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$t_key = $_POST['t_key'];
	$t_secret = $_POST['t_secret'];


		// Create connection
		$conn = new mysqli($servername, $username, $password, $database);

		// Check connection
		if ($conn->connect_error) {
			  $error = 1;
		    echo "<tr><td style='color:red;'>Connection failed: " . $conn->connect_error."</td></tr>";die;
		}else{
			  //echo "<tr><td>Successfully connected to database</td></tr>";
				mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");
				mysqli_query($conn, "drop table if exists files");
				mysqli_query($conn, "drop table if exists messages");
				mysqli_query($conn, "drop table if exists products");
				mysqli_query($conn, "drop table if exists replies");
				mysqli_query($conn, "drop table if exists tweets");
				mysqli_query($conn, "drop table if exists users");
				mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
		}

		$filename = 'sql.sql';

		// Temporary variable, used to store current query
		$templine = '';
		// Read in entire file
		$fp = fopen($filename, 'r');
		// Loop through each line
		while (($line = fgets($fp)) !== false) {
			// Skip it if it's a comment
			if (substr($line, 0, 2) == '--' || $line == '')
				continue;
			// Add this line to the current segment
			$templine .= $line;
			// If it has a semicolon at the end, it's the end of the query
			if (substr(trim($line), -1, 1) == ';') {
				// Perform the query
				if(!mysqli_query($conn, $templine)){
					$error = 1;
					print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');die;
				}
				// Reset temp variable to empty
				$templine = '';
			}
		}
		mysqli_close($conn);
		fclose($fp);

		//echo "<tr><td>Database imported successfully</td></tr>";
    $fh = fopen("config.php", 'w');
		fclose($fh);
		$fh = fopen(".htaccess", 'w');
		fclose($fh);

		if(!is_writable("config.php")) chmod("config.php",0777);
		if(!is_writable(".htaccess")) chmod(".htaccess",0777);

		$actual_link = str_replace("install.php", "", $actual_link);

		//if(file_exists("config.php")) unlink("config.php");

		$fh = fopen("config.php", 'w');

		$txt = '<?php

		define("db_host", "'.$servername.'");
		define("db_user", "'.$username.'");
		define("db_pass", "'.$password.'");
		define("db_name", "'.$database.'");
		define("baseurl", "'.$actual_link.'");
		define("twitter_consumer_key", "'.$t_key.'");
		define("twitter_consumer_secret", "'.$t_secret.'");
		define("path", dirname(BASEPATH));


		 ?>';


		fwrite($fh, $txt);
		fclose($fh);

		if(!file_exists(".htaccess")){
			$fh = fopen(".htaccess", 'w');
			$txt = 'RewriteEngine on
			RewriteCond $1 !^(index\.php|resources|robots\.txt)
			RewriteCond %{REQUEST_FILENAME} !-f
			RewriteCond %{REQUEST_FILENAME} !-d
			RewriteRule ^(.*)$ index.php/$1 [L,QSA]';

			fwrite($fh, "\n". $txt);
			fclose($fh);
		}

		//header("Location: index.php");

			$system_path = 'system';

		// Set the current directory correctly for CLI requests
		if (defined('STDIN'))
		{
			chdir(dirname(__FILE__));
		}

		if (($_temp = realpath($system_path)) !== FALSE)
		{
			$system_path = $_temp.DIRECTORY_SEPARATOR;
		}
		else
		{
			// Ensure there's a trailing slash
			$system_path = strtr(
				rtrim($system_path, '/\\'),
				'/\\',
				DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
			).DIRECTORY_SEPARATOR;
		}

		$system_path = dirname($system_path);

 }

?>

</table>

<?php if($error == 1){ ?>
<form href="<?=$actual_link?>" method="post">
	<table>
		<thead><th colspan="2">Your MYSQL details</th></thead>
		<tr>
      <td>Host:</td><td> <input type="text" name="host"></td>
		</tr>
		<tr>
      <td>Database Name:</td><td> <input type="text" name="database"></td>
		</tr><tr>
      <td>User: </td><td><input type="text" name="username"></td>
		</tr><tr>
      <td>Password: </td><td><input type="text" name="password"></td>
		</tr><tr>
		</tr><tr>
			<td>Twitter API consumer key: </td><td><input type="text" name="t_key" value=""></td>
		</tr><tr>
		</tr><tr>
			<td>Twitter API consumer secret: </td><td><input type="text" name="t_secret" value=""></td>

		</tr>

		<tr>
      <td><input type="submit" value="Install"></td>
			</tr>
		</table>
</form>
<?php } ?>

<?php if(isset($_POST['host'])) { ?>
<table>
	<thead>
		<tr>
		<th>
     <h1>Application is url <a href="<?=$actual_link?>"><?=$actual_link?></a> </h1>
    </th>
	</tr>
	<tr>
		<th>
     <h1>You have paste following code into your crontab</h1>
    </th>
	</tr>
  </thead>
	<tbody>
		<tr>
			<td>* * * * * php <?=$system_path?>/index.php twitter_cron collect_tweets_for_new_products<br>
						*/5 * * * * php <?=$system_path?>/index.php twitter_cron collect_tweets_for_new_products<br>
						* * * * * php <?=$system_path?>/index.php upload_images<br>
						* * * * * php <?=$system_path?>/index.php reply
 </td></tr>
	</tbody>
</table>
<?php } ?>

</html>
