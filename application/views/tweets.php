
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/editor.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/resources/demo.css">

	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
	</script>
	<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>

	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?=base_url()?>assets/js/dataTables.editor.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?=base_url()?>assets/resources/syntax/shCore.js">
	</script>

	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js">
	</script>


  <style>

  div.DTE button.btn, div.DTE div.DTE_Form_Buttons button{
    position: relative;
    text-align: center;
    display: block;
    margin-top: 0;
    padding: 5px 15px;
    cursor: pointer;
    float: right;
    margin-left: 0.75em;
    font-size: 14px;
    text-shadow: 0 1px 0 white;
    border: 1px solid #999;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    -ms-border-radius: 4px;
    -o-border-radius: 4px;
    border-radius: 4px;
    -webkit-box-shadow: 1px 1px 3px #ccc;
    -moz-box-shadow: 1px 1px 3px #ccc;
    box-shadow: 1px 1px 3px #ccc;
    background-color: #f9f9f9 100%;
    background-image: -webkit-linear-gradient(top, #fff 0%, #eee 65%, #f9f9f9 100%);
    background-image: -moz-linear-gradient(top, #fff 0%, #eee 65%, #f9f9f9 100%);
    background-image: -ms-linear-gradient(top, #fff 0%, #eee 65%, #f9f9f9 100%);
    background-image: -o-linear-gradient(top, #fff 0%, #eee 65%, #f9f9f9 100%);
    /* background-image: linear-gradient(to bottom, #fff 0%, #eee 65%, #f9f9f9 100%); */
    filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='#ffffff', EndColorStr='#f9f9f9');
    color:black;
  }

	td {
		word-wrap: break-word; max-width: 200px;
	}

	table.dataTable.row-border tbody tr:first-child th, table.dataTable.row-border tbody tr:first-child td, table.dataTable.display tbody tr:first-child th, table.dataTable.display tbody tr:first-child td {
    border-top: none;
    word-wrap: break-word;
    max-width: 200px;
		max-width: 40em;
		max-width: 100ch;
  }

	.dataTables_processing {
    z-index: 3000;
  }
	.example_processing{
		position: fixed;'
		width: 200px;
	}
  </style>

	<script type="text/javascript" language="javascript" class="init">

		var base_url = "<?=base_url()?>";

		var editor; // use a global for the submit and return data rendering in the examples

		$(document).ready(function() {


			$('#example').DataTable( {
		        dom: "B<clear>frtip",
						bSortClasses: false,
					  ajax: {
		            url: "<?=base_url()?>tweets/data",
		            type: "POST"
		        },

		        serverSide: true,
		        serverSide : true,
						processing: true,
						oLanguage: {
		        sProcessing: "<img width='15%' src='"+base_url+"assets/images/ajax-loader.gif'>"
		        },
		       columns: [

				      { data: "product_name", orderable: false, searchable: false, render: function ( pname, type, row ) {
				         return pname;
							}},

							<?php if(in_array("user", $table_options)){ ?>
							{ data: "user_id", searchable: false, orderable: false, render: function ( user, type, row ) {
								 //var obj = JSON.stringify(tweet);
				         return '<img style="text-align:right;" src="'+row.user.profile_image_url+'">';
							}},

							{ data: "user", searchable: false, orderable: false, render: function ( user, type, row ) {
								 //var obj = JSON.stringify(tweet);
				         return '<a style="text-align:left;" target="__blank" href="https://twitter.com/@'+user.screen_name+'">@'+user.screen_name+'</a><br>'+user.followers_count+'&nbsp;Followers&nbsp;'+user.friends_count+'&nbsp;Following';
							}},
							<?php } ?>
							<?php if(in_array("tweet", $table_options)){ ?>
							{ data : "tweet", orderable: false, searchable: true, render: function ( tweet, type, row ) {
				         return '<a id="tweet_detail_'+row.id+'">'+tweet+'</a>';
							}},

							<?php } ?>

						  <?php if(in_array("tweet", $table_options)){ ?>
							{ data : "link", orderable: false, searchable: true, render: function ( tweet, type, row ) {
				         return tweet;
							}},
							<?php } ?>
							<?php if(in_array("profile_description", $table_options)){ ?>
							{ data : "profile_description", orderable: false, searchable: true},
							<?php } ?>
							<?php if(in_array("location", $table_options)){ ?>
							{ data : "location", orderable: false, searchable: true},
							<?php } ?>
							<?php if(in_array("place", $table_options)){ ?>
							{ data : "place", orderable: false, searchable: true},
							<?php } ?>
							<?php if(in_array("geo", $table_options)){ ?>
							{ data : "geo", orderable: false, searchable: true},
							<?php } ?>
							<?php if(in_array("coordinates", $table_options)){ ?>
							{ data : "coordinates", orderable: false, searchable: true},
							<?php } ?>
							<?php if(in_array("favourited", $table_options)){ ?>
							{ data : "favorited", orderable: false, searchable: true},
							<?php } ?>
							<?php if(in_array("likes", $table_options)){ ?>
							{ data : "favorite_count", orderable: false, searchable: true},
							<?php } ?>
							<?php if(in_array("is_retweet", $table_options)){ ?>
							{ data : "is_retweet", orderable: false, searchable: true},
							<?php } ?>
							<?php if(in_array("retweet_count", $table_options)){ ?>
							{ data : "retweet_count", orderable: false, searchable: true},
							<?php } ?>
							<?php if(in_array("date", $table_options)){ ?>
							{ data: "datetime", orderable: false, searchable: false},
							<?php } ?>
							<?php if(in_array("source", $table_options)){ ?>
							{ data : "source", orderable: false, orderable: false, searchable: true, render: function ( source, type, row ) {
								var decoded = $("<div/>").html(source).text();
								return decoded;
							}}
							<?php } ?>
		      ],
		      buttons: [

				],
				"aLengthMenu": [[25, 100, 500, 1000], [25, 100,  500, 1000]],
		        "iDisplayLength": 100
			} );

			$('#example').on( 'click', '[id^="tweet_detail_"]', function (e) {
		    $("#modal-view-tweet").modal("show");
		    $("#modal-view-tweet .modal-body").html("Loading...");
				var tweet_id = $(this).attr("id").split("_")['2'];

				var get = $.get(base_url+"tweets/tweet", {id: tweet_id});

				get.done(function(data){
		     var data = JSON.parse(data);
		     $("#modal-view-tweet .modal-body").html(data.html);
		    });

				get.fail(function(data){
		     $("#modal-view-tweet .modal-body").html("<h3>Something went wrong, Try again.</h3>");
				});

			});

			$("#delete_all").click(function(){
        $("#delete_all_modal").modal("show");
			});

		 });

  </script>
  </head>
 <body>

	<div class="container-main">

	  <header>

				<?php $this->load->view("common/header1.php"); ?>

	        <style>
	        input[type="radio"] {
	            display: inline;
	            width: auto;
	            padding: 10px;
	            height : auto;

	          }
	          label.radio{
	            display: inline;
	            font-size: 12px;
	            padding-top: 10%;
	            cursor: pointer;
	          }

	        </style>
	    </header>
	    <br>
	    <br>
	    <div style="">
	      <div style="max-width: 90%;text-align:center;margin: 0 auto;">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#configuration">Configuration</button>
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#export">Export</button>
					<button type="button" class="btn btn-danger" id="delete_all">Delete All</button>
	       <table id="example" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th style="text-align:center;">Keyword</th>
              <?php if(in_array("user", $table_options)){ ?>
							<th style="text-align:center;"></th>
							<th style="text-align:center;">User</th>
							<?php } ?>
							<?php if(in_array("tweet", $table_options)){ ?>
							<th style="text-align:center;width:50%">Tweet</th>
							<th style="text-align:center;width:5%">Link</th>
							<?php } ?>
              <?php if(in_array("profile_description", $table_options)){ ?>
							<th style="text-align:center;">Profile description</th>
							<?php } ?>
							<?php if(in_array("location", $table_options)){ ?>
							<th style="text-align:center;">Location</th>
							<?php } ?>
							<?php if(in_array("place", $table_options)){ ?>
							<th style="text-align:center;">Place</th>
							<?php } ?>
							<?php if(in_array("geo", $table_options)){ ?>
							<th style="text-align:center;">Geo</th>
							<?php } ?>
							<?php if(in_array("coordinates", $table_options)){ ?>
							<th style="text-align:center;">Coordinates</th>
							<?php } ?>
							<?php if(in_array("favourited", $table_options)){ ?>
							<th style="text-align:center;">Favourited</th>
							<?php } ?>
							<?php if(in_array("likes", $table_options)){ ?>
							<th style="text-align:center;">Likes Count</th>
							<?php } ?>
							<?php if(in_array("is_retweet", $table_options)){ ?>
							<th style="text-align:center;">re-tweeted</th>
							<?php } ?>
							<?php if(in_array("retweet_count", $table_options)){ ?>
							<th style="text-align:center;">Retweet Count</th>
							<?php } ?>
							<?php if(in_array("date", $table_options)){ ?>
							<th style="text-align:center;">Date</th>
							<?php } ?>
							<?php if(in_array("source", $table_options)){ ?>
							<th style="text-align:center;">Source</th>
							<?php } ?>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th style="text-align:center;">Keyword</th>
              <?php if(in_array("user", $table_options)){ ?>
							<th style="text-align:center;"></th>
							<th style="text-align:center;">User</th>
							<?php } ?>
							<?php if(in_array("tweet", $table_options)){ ?>
							<th style="text-align:center;width:50%">Tweet</th>
							<th style="text-align:center;width:5%">Link</th>
							<?php } ?>
              <?php if(in_array("profile_description", $table_options)){ ?>
							<th style="text-align:center;">Profile description</th>
							<?php } ?>
							<?php if(in_array("location", $table_options)){ ?>
							<th style="text-align:center;">Location</th>
							<?php } ?>
							<?php if(in_array("place", $table_options)){ ?>
							<th style="text-align:center;">Place</th>
							<?php } ?>
							<?php if(in_array("geo", $table_options)){ ?>
							<th style="text-align:center;">Geo</th>
							<?php } ?>
							<?php if(in_array("coordinates", $table_options)){ ?>
							<th style="text-align:center;">Coordinates</th>
							<?php } ?>
							<?php if(in_array("favourited", $table_options)){ ?>
							<th style="text-align:center;">Favourited</th>
							<?php } ?>
							<?php if(in_array("likes", $table_options)){ ?>
							<th style="text-align:center;">Likes Count</th>
							<?php } ?>
							<?php if(in_array("is_retweet", $table_options)){ ?>
							<th style="text-align:center;">re-tweeted</th>
							<?php } ?>
							<?php if(in_array("retweet_count", $table_options)){ ?>
							<th style="text-align:center;">Retweet Count</th>
							<?php } ?>
							<?php if(in_array("date", $table_options)){ ?>
							<th style="text-align:center;">Date</th>
							<?php } ?>
							<?php if(in_array("source", $table_options)){ ?>
							<th style="text-align:center;">Source</th>
							<?php } ?>
						</tr>
					</tfoot>
				</table>
	    </div>
	   </div>
	 </div>

	</body>

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css">

	<!-- Modal -->
	    <div class="modal fade" id="modal-view-tweet" role="dialog">
	   	 <div class="modal-dialog" >

	   		 <!-- Modal content-->
	   		 <div class="modal-content" >
	   			 <div class="modal-header">
	   				 <button type="button" class="close" data-dismiss="modal">&times;</button>
	   				 <h4 class="modal-title" id="tweet-title"></h4>
	   			 </div>

	   			 <div class="modal-body">

	         </div>

	   		 </div>

	   	 </div>
	    </div>


			<!-- Modal -->
			 <div class="modal fade" id="export" role="dialog">
				 <div class="modal-dialog">

					 <!-- Modal content-->
					 <div class="modal-content">
						 <div class="modal-header">
							 <button type="button" class="close" data-dismiss="modal">&times;</button>
							 <h4 class="modal-title">Export Tweets</h4>
						 </div>
						 <div class="modal-body">
							 <div class="container">

							 <form id="export_form" action="<?=base_url()?>export_data/" method="post">
								 <input type="hidden" name="export_type" id="export_type" value="csv">
								 <input type="hidden" name="page" id="page" value="0">
								 <style>
								 input{
									 display: inline;
									 height: 20px;
									 width: 20px;
								 }

								 ul.checkbox-grid{
									 width: 100%;
									 margin-left: 0px;
								 }

								 ul.checkbox-grid li{
									 list-style-type: none;
									 display: inline;
									 font-weight: normal;
									 padding: 5px 5px;
								 }

								 ul.checkbox-grid li input{
									 vertical-align: middle;
								 }

								 ul.checkbox-grid li label{
									 font-weight: normal;
									 cursor: pointer;
								 }

									ul.checkbox-grid li input:checked + label {
										font-weight: bold;
										background: #d0d0d0;
									}


								 ul.checkbox-grid li:hover{
									 color: white;
									 background: #d0d0d0;
								 }


									.modal-body{
											height: 100%;
											overflow-y: auto;
											overflow-x: hidden;
									}

								 ul.checkbox-grid:first-child li:first-child input:first-child{
									 margin-left: -20em;
								 }

								 </style>
								 <div class="control-group">
									<p class="pull-left">Choose keywords to export.</p><br>
									<ul class="checkbox-grid"> </ul>

							 <?php $i = 0; if($products->num_rows() > 0){
								 foreach($products->result() as $product){ ?>
										<?php if($i == 0){ ?> <ul class="checkbox-grid"> <?php } ?>
											<li><input name="keywords[]" <?php if(in_array($product->product_name, $table_options)) echo "checked"; ?> id="text<?=$product->id?>" type="checkbox" value="<?=$product->id?>" />&nbsp;<label for="text<?=$product->id?>"><?=substr($product->product_name, "0", "20")?></label></li>
									 <?php $i++; if($i > 2){ ?> </ul> <?php $i = 0; } ?>
									<?php   }  }else{ ?>
										 No products added or not graph data update. Please revisit after few hours.
									 <?php } ?>

									 <br><br>
									 	 <p class="pull-left">Choose detail to include on export.</p><br><br>

									 <ul class="checkbox-grid"></ul>
									 <ul class="checkbox-grid"></ul>

									 <ul class="checkbox-grid">
										 <li>
											<input name="export_options[]" <?php if(in_array('product', $export_options)) echo "checked"; ?> id="keyword1" type="checkbox" value="product" />&nbsp;
											<label for="keyword1">Keyword</label>
										</li>

										 <li>
 											<input name="export_options[]" <?php if(in_array('user', $export_options)) echo "checked"; ?> id="user" type="checkbox" value="user" />&nbsp;
 											<label for="user">User Information</label>
 										</li>

										<li>
											<input name="export_options[]" <?php if(in_array('location', $export_options)) echo "checked"; ?> id="location" type="checkbox" value="location" />&nbsp;
											<label for="location">Location</label>
										</li>
									</ul>

									 <ul class="checkbox-grid">
										 <li>
	 										<input name="export_options[]" <?php if(in_array('favourited', $export_options)) echo "checked"; ?> id="favourited" type="checkbox" value="favourited" />&nbsp;
	 										<label for="favourited">Favourited</label>
	 									</li>
										 <li>
	 										<input name="export_options[]" <?php if(in_array('likes', $export_options)) echo "checked"; ?> id="likes" type="checkbox" value="likes" />&nbsp;
	 										<label for="likes">Likes or Favourite count</label>
	 									</li>
                   </ul>

										<ul class="checkbox-grid">
											<li>
											 <input name="export_options[]" <?php if(in_array('is_retweet', $export_options)) echo "checked"; ?> id="is_retweet" type="checkbox" value="is_retweet" />&nbsp;
											 <label for="is_retweet"> re-tweeted</label>
										 </li>
											<li>
 											 <input name="export_options[]" <?php if(in_array('retweet_count', $export_options)) echo "checked"; ?> id="retweet_count" type="checkbox" value="retweet_count" />&nbsp;
 											 <label for="retweet_count"> Retweet count</label>
 										 </li>
									 </ul>
									 <ul class="checkbox-grid">
										 	<li>
  											<input name="export_options[]" <?php if(in_array('tweet', $export_options)) echo "checked"; ?> id="tweet" type="checkbox" value="tweet" />&nbsp;
  											<label for="tweet">Tweet</label>
  										</li>

											<li>
  											<input name="export_options[]" <?php if(in_array('date', $export_options)) echo "checked"; ?> id="date" type="checkbox" value="date" />&nbsp;
  											<label for="date">Tweet date</label>
  										</li>


											<li>
											 <input name="export_options[]" <?php if(in_array('profile_description', $export_options)) echo "checked"; ?> id="profile_description" type="checkbox" value="profile_description" />&nbsp;
											 <label for="profile_description">Profile Description</label>
										 </li>
									  </ul>

									 <ul class="checkbox-grid">
										 <li>
											 <input name="export_options[]" <?php if(in_array('geo', $export_options)) echo "checked"; ?> id="geo" type="checkbox" value="geo" />&nbsp;
											 <label for="geo">Geo</label>
										 </li>
									 </ul>

										<ul class="checkbox-grid">

											<li>
												<input name="export_options[]" <?php if(in_array('place', $export_options)) echo "checked"; ?> id="place" type="checkbox" value="place" />&nbsp;
												<label for="place">Place</label>
											</li>
											<li>
												<input name="export_options[]" <?php if(in_array('coordinates', $export_options)) echo "checked"; ?> id="coordinates" type="checkbox" value="coordinates" />&nbsp;
												<label for="coordinates">Coordinates</label>
											</li>

											<li>
												<input name="export_options[]" <?php if(in_array('source', $export_options)) echo "checked"; ?> id="source" type="checkbox" value="source" />&nbsp;
												<label for="source">Source</label>
											</li>
										</ul>
										<br><br>

										<h4> Do you want to delete after export? <br>(Not recommended on large data export)</h4>

										<ul class="checkbox-grid">
 										 <li>
  											<input name="delete" id="delete" type="radio" value="1" />&nbsp;
  											<label for="delete">Yes</label>
  										</li>
											<li>
   											<input name="delete" id="delete1" type="radio" value="0" checked/>&nbsp;
   											<label for="delete1">No</label>
   										</li>

										</li>
						 </div>
					 </div>
					 <div id="notify" style="padding: 10px 10px;margin: 10px 10px auto; text-align: center;" >
					 </div>
					 </form>
						 <div class="modal-footer" >
							 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							 <button type="button" class="btn btn-primary" id="export_xls">Excel</button>
							 <button type="button" class="btn btn-primary" id="export_csv">CSV</button>
						 </div>
					 </div>

				 </div>
			 </div>
		 </div>


			 <!-- Modal -->
				<div class="modal fade" id="configuration" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Settings for table fields</h4>
							</div>
							<div class="modal-body">
								<div class="container">

								<form id="table_fields">
									<style>
									input{
										display: inline;
										height: 20px;
										width: 20px;

									}

									ul.checkbox-grid{
										width: 100%;
										margin-left: 0px;
									}

									ul.checkbox-grid li{
										list-style-type: none;
										display: inline;
										font-weight: normal;
										padding: 5px 5px;
									}

									ul.checkbox-grid li input{
										vertical-align: middle;
									}

									ul.checkbox-grid li label{
										font-weight: normal;
										cursor: pointer;
									}

									 ul.checkbox-grid li input:checked + label {
										 font-weight: bold;
										 background: #d0d0d0;
									 }


									ul.checkbox-grid li:hover{
										color: white;
										background: #d0d0d0;
									}


									 .modal-body{
											 height: 100%;
											 overflow-y: auto;
											 overflow-x: hidden;
									 }

									ul.checkbox-grid:first-child li:first-child input:first-child{
										margin-left: -20em;
									}

									.dataTables_wrapper .dataTables_filter input{
										width: 200px;
										height: 30px;
									}

									</style>
									<div class="control-group">
									 <p class="pull-left">Choose keywords that should appear on table.</p><br>
									 <ul class="checkbox-grid"></ul>
									 <ul class="checkbox-grid">



										 									 <li>
										 										<input name="table_options[]" <?php if(in_array('user', $table_options)) echo "checked"; ?> id="user1" type="checkbox" value="user" />&nbsp;
										 										<label for="user1">User Information</label>
										 									</li>

										 									<li>
										 										<input name="table_options[]" <?php if(in_array('location', $table_options)) echo "checked"; ?> id="location1" type="checkbox" value="location" />&nbsp;
										 										<label for="location1">Location</label>
										 									</li>
										 								</ul>

										 								 <ul class="checkbox-grid">
										 									 <li>
										 										<input name="table_options[]" <?php if(in_array('favourited', $table_options)) echo "checked"; ?> id="favourited1" type="checkbox" value="favourited" />&nbsp;
										 										<label for="favourited1">Favourited</label>
										 									</li>
										 									 <li>
										 										<input name="table_options[]" <?php if(in_array('likes', $table_options)) echo "checked"; ?> id="likes1" type="checkbox" value="likes" />&nbsp;
										 										<label for="likes1">Likes or Favourite count</label>
										 									</li>
										 								 </ul>

										 									<ul class="checkbox-grid">
										 										<li>
										 										 <input name="table_options[]" <?php if(in_array('is_retweet', $table_options)) echo "checked"; ?> id="is_retweet1" type="checkbox" value="is_retweet" />&nbsp;
										 										 <label for="is_retweet1"> re-tweeted</label>
										 									 </li>
										 										<li>
										 										 <input name="table_options[]" <?php if(in_array('retweet_count', $table_options)) echo "checked"; ?> id="retweet_count1" type="checkbox" value="retweet_count" />&nbsp;
										 										 <label for="retweet_count1"> Retweet count</label>
										 									 </li>
										 								 </ul>
										 								 <ul class="checkbox-grid">
										 										<li>
										 											<input name="table_options[]" <?php if(in_array('tweet', $table_options)) echo "checked"; ?> id="tweet1" type="checkbox" value="tweet" />&nbsp;
										 											<label for="tweet1">Tweet</label>
										 										</li>

										 										<li>
										 											<input name="table_options[]" <?php if(in_array('date', $table_options)) echo "checked"; ?> id="date1" type="checkbox" value="date" />&nbsp;
										 											<label for="date1">Tweet date</label>
										 										</li>


										 										<li>
										 										 <input name="table_options[]" <?php if(in_array('profile_description', $table_options)) echo "checked"; ?> id="profile_description1" type="checkbox" value="profile_description" />&nbsp;
										 										 <label for="profile_description1">Profile Description</label>
										 									 </li>
										 									</ul>

										 								 <ul class="checkbox-grid">
										 									 <li>
										 										 <input name="table_options[]" <?php if(in_array('geo', $table_options)) echo "checked"; ?> id="geo1" type="checkbox" value="geo" />&nbsp;
										 										 <label for="geo1">Geo</label>
										 									 </li>
										 								 </ul>

										 									<ul class="checkbox-grid">

										 										<li>
										 											<input name="table_options[]" <?php if(in_array('place', $table_options)) echo "checked"; ?> id="place1" type="checkbox" value="place" />&nbsp;
										 											<label for="place1">Place</label>
										 										</li>
										 										<li>
										 											<input name="table_options[]" <?php if(in_array('coordinates', $table_options)) echo "checked"; ?> id="coordinates1" type="checkbox" value="coordinates" />&nbsp;
										 											<label for="coordinates1">Coordinates</label>
										 										</li>

										 										<li>
										 											<input name="table_options[]" <?php if(in_array('source', $table_options)) echo "checked"; ?> id="source1" type="checkbox" value="source" />&nbsp;
										 											<label for="source1">Source</label>
										 										</li>
										 									</ul>
							</div>
						</div>
						</form>
							<div class="modal-footer" >
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary" id="save_table_fields">Save</button>
							</div>
						</div>

					</div>
				</div>
			</div>

			<a href="" id="download"></a>


				<!-- Modal -->
				 <div class="modal fade" id="delete_all_modal" role="dialog">
					 <div class="modal-dialog">

						 <!-- Modal content-->
						 <div class="modal-content">
							 <div class="modal-header">
								 <button type="button" class="close" data-dismiss="modal">&times;</button>
								 <h4 class="modal-title">Delete Confirmation</h4>
							 </div>
							 <div class="modal-body">
								 <div class="container">
									 <h3>Are you sure you want to delete all tweets?</h3>
									 <br>
            		 </div>
						 </form>
							 <div class="modal-footer" >
								 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								 <button type="button" class="btn btn-danger" id="delete_all_tweets">Delete</button>
							 </div>
						 </div>

					 </div>
				 </div>
			 </div>

			 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

			 <script>
		 	 $(function(){
		 		 $("#save_table_fields").click(function(){
		 			 //$(this).attr("disabled", "true");
		 			 $(this).html("Saving...");

		 			 var get = $.post("<?=base_url()?>dashboard/save_table_options", $("#table_fields").serialize());

		 			 get.done(function(data){
		 					 $("#save_table_fields").html("Save");
		 					 $("#configuration").modal("hide");
		 					 window.location.reload();
		 			 });

		 			 get.fail(function(data){
		 					$("#save_table_fields").html("Save");
		 					alert("something went wrong try again.")
		 			 });
		 		 });

				 $("#delete_all_tweets").click(function(){
		 			 //$(this).attr("disabled", "true");
		 			 $(this).html("Deleting...");

		 			 var get = $.get("<?=base_url()?>dashboard/delete_all_tweets");

		 			 get.done(function(data){
						   var data = JSON.parse(data);
							 if(data.code == 200){
									$("#delete_all_tweets").html("Delete");
									$("#delete_all_modal").modal("hide");
									window.location.reload();
								}else{
									$("#delete_all_tweets").html("Delete");
									alert("something went wrong try again.")
								}
		 			 });

		 			 get.fail(function(data){
		 					$("#delete_all_tweets").html("Delete");
		 					alert("something went wrong try again.")
		 			 });
		 		 });


			    $('#export_csv').click(function(){
            export_data("CSV", 0);
					});

					$('#export_xls').click(function(){
            export_data("XLS", 0);
					});
			 });

			 var page = 0;
       var datacontent = "";


			 function export_data(format, page){

				  page = $("#page").val();

					if(page == 0) $("#notify").html("<span style='color:orange;border:1px solid orange;padding: 5px;'>Exporting data, Please wait untill it finish..</span>");

					if(format == "XLS"){
						 $("#export_type").val("xls");
					}else{
						 $("#export_type").val("csv");
					}

					if(page == 0) datacontent = "";

					var get = $.post("<?=base_url()?>export_data/", $("#export_form").serialize());

					get.done(function(data){
						var data = JSON.parse(data);
						    if(data.code == 200){
								    $("#notify").html("<span style='color:orange;border:1px solid orange;padding: 5px;'>Got "+data.page*data.count+" records, processing...</span>");

										if(data.count == 10000){
											$("#page").val(data.page);
											export_data(format, data.page);
                      datacontent += data.data;

										}else if(data.count > 0){
											$("#page").val("0");

											datacontent += data.data;

											$("#notify").html("<span style='color:green;border:1px solid green;padding: 5px;'>Export compeleted...</span>");

											downloadcsv(format, datacontent, data.filename);

											if($("#delete").is(':checked')){
												 $("#notify").html("<span style='color:orange;border:1px solid orange;padding: 5px;'>Export compeleted and deleting your tweets</span>");
												 delete_tweets();
											}
										}

								}else{
									$("#page").val("0");
									$("#notify").html("<span style='color:red;border:1px solid red;padding: 5px;'>"+data.message+"</span>");
									return;
						    }
					});

					get.fail(function(data){
						$("#page").val("0");
						$("#notify").html("<span style='color:red;border:1px solid red;padding: 5px;'>Something went wrong, refresh a page and try again.</span>");
						return;
					});
       }


			 function delete_tweets(){
				 var get = $.post("<?=base_url()?>export_data/delete_tweets", $("#export_form").serialize());

				 get.done(function(data){
					 var data = JSON.parse(data);
							 if(data.code == 200){
									 $("#notify").html("<span style='color:green;border:1px solid green;padding: 5px;'>Export compelted and Tweets Deleted.</span>");
							 }else{
									 $("#notify").html("<span style='color:red;border:1px solid red;padding: 5px;'>Export compelted but can't able to delete exported tweets, please do it manually.</span>");
									 return;
							 }
				 });

				 get.fail(function(data){
					  $("#notify").html("<span style='color:red;border:1px solid red;padding: 5px;'>Export compelted but can't able to delete exported tweets, please do it manually.</span>");
					 return;
				 });
			 }

			 function downloadcsv(format, csvData, filename){


				 if(format == "CSV"){
					var type = "csv";
				 }else{
					var type = "csv";
				 }


				if (window.navigator.msSaveOrOpenBlob) {
					 // IE 10+
					 var blob = new Blob([decodeURIComponent(encodeURI(csvData))], {
						 type: 'application/'+type+';charset=utf-8;'
					 });
					 window.navigator.msSaveBlob(blob, filename);
				 } else {
						  // actual real browsers
						  //Data URI
						  //csvData = encodeURIComponent(csvData);

							var blobdata = new Blob([csvData],{type : 'application/'+type});
							var link = document.createElement("a");
							link.setAttribute("href", window.URL.createObjectURL(blobdata));
							link.setAttribute("download", filename);
							document.body.appendChild(link);
							link.click();
							return;

							var a         = document.createElement('a');
							a.style = "visibility:hidden";

							if(format == "CSV"){
								 a.href        = 'data:application/csv;charset=utf-8, ' +  csvData;
							}else{
                 a.href        = 'data:application/xlsx;charset=utf-8, ' +  csvData;
							}
							a.target      = '_blank';
							a.download    = filename;

							document.body.appendChild(a);
							a.click();
							//document.body.removeChild(a);
						}
			 }

		     <?php if($this->session->userdata("error")){ ?>
		        alert('<?=$this->session->userdata("error")?>');
				 <?php $this->session->unset_userdata("error"); } ?>


 		 	</script>
	</html>
