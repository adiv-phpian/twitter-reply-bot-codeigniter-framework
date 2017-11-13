<?php

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;


  class Datatables{

    public function get_motors($user_id){

  		// DataTables PHP library
  		include( "php/DataTables.php" );

  		// Build our Editor instance and process the data coming from _POST
  		Editor::inst( $db, 'products' )->where( 'user_id', $user_id)
  			->fields(
				Field::inst( 'id' ),
        Field::inst( 'product_name' )
           ->validator( 'Validate::notEmpty' ),
				Field::inst( 'last_search' )
           ->validator( 'Validate::notEmpty' ),
				Field::inst( 'added_date' )
	            ->validator( 'Validate::notEmpty' ),
        Field::inst( 'user_id' )->setValue($user_id)
        )
  			->process( $_POST )
  			->json();
    }

		public function get_replies($user_id, $image){

			// DataTables PHP library
			include( "php/DataTables.php" );

			// Build our Editor instance and process the data coming from _POST
			Editor::inst( $db, 'messages' )->where( 'user_id', $user_id)
				->fields(
				Field::inst( 'id' ),
				Field::inst( 'search_id' ),
				Field::inst( 'image' ) ->setFormatter( 'Format::ifEmpty', null )
            ->upload( Upload::inst( path.'/assets/images/__ID__.__EXTN__' )
                ->db( 'files', 'id', array(
                    'image'    => Upload::DB_FILE_NAME,
                    'filesize'    => Upload::DB_FILE_SIZE,
                    'web_path'    => Upload::DB_WEB_PATH,
                    'system_path' => Upload::DB_SYSTEM_PATH
                ) )
                ->validator( function ( $file ) {
                    return $file['size'] >= 500000000000000 ?
                        "Files must be smaller than 500MB" :
                        null;
                } )
                ->allowedExtensions( array( 'jpeg', 'png', 'jpg', 'gif' ), "Please upload an image" )
            )
					,
				Field::inst( 'reply' )
					 ->validator( 'Validate::notEmpty' ),
				Field::inst( 'is_ready' )->setValue($image),
				Field::inst( 'twitter_media_id' )->setValue($image ? 0 : 1),
				Field::inst( 'last_updated' )
							->validator( 'Validate::notEmpty' ),
				Field::inst( 'user_id' )->setValue($user_id)
				)
				->process( $_POST )
				->json();
		}

			public function get_apps($user_id){
	  		// DataTables PHP library
	  		include( "php/DataTables.php" );

	  		// Build our Editor instance and process the data coming from _POST
	  		Editor::inst( $db, 'user_cred' )->where( 'main_user_id', $user_id)
	  			->fields(
					Field::inst( 'identification_name' )
	           ->validator( 'Validate::notEmpty' ),
					Field::inst( 'oauth_token_secret' )
	 	           ->validator( 'Validate::notEmpty' ),
	        Field::inst( 'consumer_key' )
	           ->validator( 'Validate::notEmpty' ),
	        Field::inst( 'consumer_secret' )
	  				 ->validator( 'Validate::notEmpty' ),
	        Field::inst( 'last_used' )
	           ->validator( 'Validate::notEmpty' ),
					Field::inst( 'added_date' )
		            ->validator( 'Validate::notEmpty' ),
	        Field::inst( 'main_user_id' )->setValue($user_id)
	        )
	  			->process( $_POST )
	  			->json();
	      }


				public function get_tweets($user_id){
					$post = array();

					include( "php/DataTables.php" );

						// storing  request (ie, get/post) global array to a variable
						$requestData = $_REQUEST;

						$columns = array(
						// datatable column index  => database column name
								0 =>'product_name',
								1 => 'tweet',
								2 => 'datetime',
								3 => 'id',
								4  => "user_id",
								5 => "product_id"
						);


						include("php/config.php");

						$conn =  new mysqli( "localhost", $sql_details['user'], $sql_details['pass'], $sql_details['db']  );

						if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
						}


						$sql = "SELECT count(id) as tweets_count";
						$sql.=" FROM tweets WHERE user_id = $user_id";

						if( !empty($requestData['search']['value']) ){  //salary
								$sql.=" AND tweet LIKE '%".$requestData['search']['value']."%' ";
						}


						$query = $conn->query($sql);

						$total = 0;  // when there is no search parameter then total number rows = total number filtered rows.
						if($query->num_rows > 0) $total = $query->fetch_assoc()['tweets_count'];

						$sql = "SELECT id, product_name, product_id, tweet, user_id, tweet_json, datetime  ";
						$sql.=" FROM tweets WHERE user_id = $user_id";

						if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
								//$sql.=" AND tweet LIKE '%".$requestData['columns'][1]['search']['value']."%' ";
						}

						if( !empty($requestData['search']['value']) ){  //salary
								$sql.=" AND (tweet LIKE '%".$requestData['search']['value']."%' OR product_name LIKE '%".$requestData['search']['value']."%') ";
						}

						//$sql.=" ORDER BY product_name ".$requestData['order'][0]['dir']." ";


						if($requestData['length'] == -1){
							//$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']." ";  // adding length
						}else{
							$sql.= " LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length
						}

						$query = $conn->query($sql);

						$totalFiltered = $query->num_rows;

						$data = array();
						while( $row = $query->fetch_assoc() ) {  // preparing an array
								$nestedData=array();

								$tweet_json = json_decode($row["tweet_json"]);

								$nestedData["DT_RowId"] = "row_".$row['id'];
								$nestedData["id"] = $row["id"];
								$nestedData["datetime"] = $row["datetime"];
								$nestedData["product_id"] = $row["product_id"];
								$nestedData["product_name"] = $row["product_name"];
								$nestedData["user"] = $tweet_json->user;
								$nestedData["location"] = $tweet_json->user->location;
								$nestedData["profile_description"] = $tweet_json->user->description;
								$nestedData["coordinates"] = $tweet_json->coordinates ? implode(" ", $tweet_json->coordinates->coordinates) : ' ';
								$nestedData["place"] = $tweet_json->place ? $tweet_json->place->full_name : ' ';
								$nestedData["geo"] = $tweet_json->geo ? implode(" ", $tweet_json->geo->coordinates) : ' ';
								$nestedData["retweet_count"] = $tweet_json->retweet_count;
								$nestedData["favorite_count"] = $tweet_json->favorite_count;
								$nestedData["favorited"] = $tweet_json->favorited;
								$nestedData["is_retweet"] = $tweet_json->retweeted;
								$nestedData["tweet"] = $tweet_json->text;
								$nestedData["link"] = "<a target='__blank' href='https://twitter.com/".$tweet_json->user->screen_name."/status/".$tweet_json->id_str."'>Link</a>";
								$nestedData["user_id"] = $row["user_id"];
								$nestedData["source"] = htmlspecialchars($tweet_json->source);

								$data[] = $nestedData;
						}

						$json_data = array(
												"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
												"recordsTotal"    => intval( $total ),  // total number of records
												"recordsFiltered" => intval( $total ), // total number of records after searching, if there is no searching then totalFiltered = totalData
												"data"            => $data   // total data array
												);

						echo json_encode($json_data);  // send data as json format





				}

			 public function get_tweets_by_cate($type, $product, $user_id){
					$post = array();
					//print_r("<pre>");print_r($user_id);print_r("</pre>");die;
		  		// DataTables PHP library
		  		include( "php/DataTables.php" );

					if($type == "all_tweets"){
          // storing  request (ie, get/post) global array to a variable
					$requestData = $_REQUEST;

					$columns = array(
					// datatable column index  => database column name
							0 =>'product_name',
							1 => 'tweet',
							2 => 'datetime',
							3 => 'id',
							4  => "user_id",
							5 => "product_id"
					);


					include("php/config.php");

					$conn =  new mysqli( "localhost", $sql_details['user'], $sql_details['pass'], $sql_details['db']  );

					if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
					}


					$sql = "SELECT count(id) as tweets_count";
					$sql.=" FROM tweets WHERE product_id = $product->id AND user_id = $user_id ";

					if( !empty($requestData['search']['value']) ){  //salary
							$sql.=" AND tweet LIKE '%".$requestData['search']['value']."%' ";
					}

					$query = $conn->query($sql);
					$total = 0;  // when there is no search parameter then total number rows = total number filtered rows.
					if($query->num_rows > 0) $total = $query->fetch_assoc()['tweets_count'];

					$sql = "SELECT id, product_name, product_id, tweet, user_id, tweet_json, datetime  ";
					$sql.=" FROM tweets WHERE product_id = $product->id AND user_id = $user_id";

					if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
							//$sql.=" AND tweet LIKE '%".$requestData['columns'][1]['search']['value']."%' ";
					}

					if( !empty($requestData['search']['value']) ){  //salary
							$sql.=" AND tweet LIKE '%".$requestData['search']['value']."%'";
					}

					//$sql.=" ORDER BY product_name ".$requestData['order'][0]['dir']." ";

					if($requestData['length'] == -1){
						//$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']." ";  // adding length
					}else{
						$sql.= " LIMIT ".$requestData['start']." ,".$requestData['length']." ";  // adding length
					}

					//print_R($sql);die;

					$query = $conn->query($sql);

					$totalFiltered = $query->num_rows;

					$data = array();
					while( $row = $query->fetch_assoc() ) {  // preparing an array
							$nestedData=array();

							$tweet_json = json_decode($row["tweet_json"]);

							$nestedData["DT_RowId"] = "row_".$row['id'];
							$nestedData["id"] = $row["id"];
							$nestedData["datetime"] = $row["datetime"];
							$nestedData["product_id"] = $row["product_id"];
							$nestedData["product_name"] = $row["product_name"];
							$nestedData["user"] = $tweet_json->user;
							$nestedData["location"] = $tweet_json->user->location;
							$nestedData["profile_description"] = $tweet_json->user->description;
							$nestedData["coordinates"] = $tweet_json->coordinates ? implode(" ", $tweet_json->coordinates->coordinates) : ' ';
							$nestedData["place"] = $tweet_json->place ? $tweet_json->place->full_name : ' ';
							$nestedData["geo"] = $tweet_json->geo ? implode(" ", $tweet_json->geo->coordinates) : ' ';
							$nestedData["retweet_count"] = $tweet_json->retweet_count;
							$nestedData["favorite_count"] = $tweet_json->favorite_count;
							$nestedData["favorited"] = $tweet_json->favorited;
							$nestedData["is_retweet"] = $tweet_json->retweeted;
							$nestedData["tweet"] = $tweet_json->text;
							$nestedData["user_id"] = $row["user_id"];
							$nestedData["source"] = htmlspecialchars($tweet_json->source);

							$data[] = $nestedData;
					}

					$json_data = array(
											"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
											"recordsTotal"    => intval( $total ),  // total number of records
											"recordsFiltered" => intval( $total ), // total number of records after searching, if there is no searching then totalFiltered = totalData
											"data"            => $data   // total data array
											);

					echo json_encode($json_data);  // send data as json format


					}elseif($type == "and_tweets"){
						// storing  request (ie, get/post) global array to a variable
						$requestData = $_REQUEST;

						$columns = array(
						// datatable column index  => database column name
								0 =>'product_name',
								1 => 'tweet',
								2 => 'datetime',
								3 => 'id',
								4  => "user_id",
								5 => "product_id"
						);


						include("php/config.php");

						$conn =  new mysqli( "localhost", $sql_details['user'], $sql_details['pass'], $sql_details['db']  );

						if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
						}

						$or_keywords = "(";

						foreach(explode(",", $product->keywords) as $key => $keyword){
							$keyword = trim($keyword);

							if($key > 0) $or_keywords .= " AND ";
							$keyword = mysqli_real_escape_string($conn, $keyword);
							$or_keywords .= "tweet LIKE '% $keyword %'";
						}

						$or_keywords .= ")";


						// getting total number records without any search
						#$sql = "SELECT id ";
						#$sql.= " FROM tweets where product_id = $product->id AND $or_keywords";

						$sql = "SELECT id, product_name, product_id, tweet, user_id, tweet_json, datetime  ";
						$sql.=" FROM tweets WHERE product_id = $product->id AND $or_keywords";

						if( !empty($requestData['search']['value']) ){  //salary
								$sql.=" AND tweet LIKE '%".$requestData['search']['value']."%' ";
						}

						$query = $conn->query($sql);
						$total = $query->num_rows;  // when there is no search parameter then total number rows = total number filtered rows.

						$sql = "SELECT id, product_name, product_id, tweet, user_id, tweet_json, datetime  ";
						$sql.=" FROM tweets WHERE product_id = $product->id AND $or_keywords";

						if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
								//$sql.=" AND tweet LIKE '%".$requestData['columns'][1]['search']['value']."%' ";
						}

						if( !empty($requestData['search']['value']) ){  //salary
								$sql.=" AND tweet LIKE '%".$requestData['search']['value']."%' ";
						}

						if($requestData['length'] == -1){
							$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']." ";  // adding length
						}else{
							$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length
						}

						///print_R($sql);die;

						$query = $conn->query($sql);

						$totalFiltered = $query->num_rows;

						$data = array();
						while( $row = $query->fetch_assoc() ) {  // preparing an array
								$nestedData=array();

								$nestedData["DT_RowId"] = "row_".$row['id'];
								$nestedData["id"] = $row["id"];
								$nestedData["datetime"] = $row["datetime"];
								$nestedData["product_id"] = $row["product_id"];
								$nestedData["product_name"] = $row["product_name"];
								$nestedData["user"] = json_decode($row["tweet_json"])->user;
								$nestedData["tweet"] = json_decode($row["tweet_json"])->text;
								$nestedData["user_id"] = $row["user_id"];

								$data[] = $nestedData;
						}

						$json_data = array(
												"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
												"recordsTotal"    => intval( $total ),  // total number of records
												"recordsFiltered" => intval( $total ), // total number of records after searching, if there is no searching then totalFiltered = totalData
												"data"            => $data   // total data array
												);

						echo json_encode($json_data);  // send data as json format


         }elseif($type == "or_tweets"){

							// storing  request (ie, get/post) global array to a variable
							$requestData = $_REQUEST;

							$columns = array(
							// datatable column index  => database column name
							    0 =>'product_name',
							    1 => 'tweet',
							    2 => 'datetime',
									3 => 'id',
									4  => "user_id",
									5 => "product_id"
							);


							include("php/config.php");

							$conn =  new mysqli( "localhost", $sql_details['user'], $sql_details['pass'], $sql_details['db']  );

							if ($conn->connect_error) {
							    die("Connection failed: " . $conn->connect_error);
							}

							$or_keywords = "(";

							foreach(explode(",", $product->keywords) as $key => $keyword){
								$keyword = trim($keyword);

								if($key > 0) $or_keywords .= " OR ";
								$keyword = mysqli_real_escape_string($conn, $keyword);
								$or_keywords .= "tweet LIKE '% $keyword %'";
							}

							$or_keywords .= ")";


              // getting total number records without any search
							#$sql = "SELECT id ";
							#$sql.= " FROM tweets where product_id = $product->id AND $or_keywords";

							$sql = "SELECT id, product_name, product_id, tweet, user_id, tweet_json, datetime  ";
							$sql.=" FROM tweets WHERE product_id = $product->id AND $or_keywords";

							if( !empty($requestData['search']['value']) ){  //salary
									$sql.=" AND tweet LIKE '%".$requestData['search']['value']."%' ";
							}

							$query = $conn->query($sql);
							$total = $query->num_rows;  // when there is no search parameter then total number rows = total number filtered rows.

							$sql = "SELECT id, product_name, product_id, tweet, user_id, tweet_json, datetime  ";
							$sql.=" FROM tweets WHERE product_id = $product->id AND $or_keywords";

              if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
							    //$sql.=" AND tweet LIKE '%".$requestData['columns'][1]['search']['value']."%' ";
							}

							if( !empty($requestData['search']['value']) ){  //salary
							    $sql.=" AND tweet LIKE '%".$requestData['search']['value']."%' ";
							}

							if($requestData['length'] == -1){
								$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']." ";  // adding length
							}else{
								$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length
							}

							///print_R($sql);die;

							$query = $conn->query($sql);

							$totalFiltered = $query->num_rows;

							$data = array();
							while( $row = $query->fetch_assoc() ) {  // preparing an array
							    $nestedData=array();

							    $nestedData["DT_RowId"] = "row_".$row['id'];
							    $nestedData["id"] = $row["id"];
							    $nestedData["datetime"] = $row["datetime"];
									$nestedData["product_id"] = $row["product_id"];
									$nestedData["product_name"] = $row["product_name"];
									$nestedData["user"] = json_decode($row["tweet_json"])->user;
									$nestedData["tweet"] = json_decode($row["tweet_json"])->text;;
									$nestedData["user_id"] = $row["user_id"];

							    $data[] = $nestedData;
							}

							$json_data = array(
							            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
							            "recordsTotal"    => intval( $total ),  // total number of records
							            "recordsFiltered" => intval( $total ), // total number of records after searching, if there is no searching then totalFiltered = totalData
							            "data"            => $data   // total data array
							            );

							echo json_encode($json_data);  // send data as json format

         }
			}
  }
?>
