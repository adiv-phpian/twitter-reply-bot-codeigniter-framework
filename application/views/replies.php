<?php $asset_url = str_replace("index.php/", "", base_url()).'assets/'; ?>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?=$asset_url?>/css/editor.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?=$asset_url?>/resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="<?=$asset_url?>/resources/demo.css">

	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
	</script>
	<script src="<?=$asset_url?>/js/bootstrap.min.js"></script>

	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?=$asset_url?>/js/dataTables.editor.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?=$asset_url?>/resources/syntax/shCore.js">
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

	table.dataTable.display tbody tr td img{
		max-width: 100px;
	}

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
    var search = new Array();
		<?php foreach($search as $key => $value){ ?>
		 search["<?=$value->id?>"] = "<?=$value->product_name?>";
		<?php } ?>

		var base_url = "<?=base_url()?>";

		var editor; // use a global for the submit and return data rendering in the examples

		$(document).ready(function() {

			editor = new $.fn.dataTable.Editor( {
				ajax: base_url+"replies/data",
				table: "#example",
				fields: [
					{
							label: "Search query:",
							name:  "search_id",
							type:  "select",
							options: getStateList()
					},

					{
						label: "Reply:",
						name: "reply",
						type: "textarea",
						maxlength : 120
					},
					{
                label: "Image:",
                name: "image",
                type: "upload",
                display: function ( file_id ) {
                    return '<img src="'+editor.file( 'files', file_id ).web_path+'"/>';
                },
                clearText: "Clear",
                noImageText: 'No image'
          }
				]
			} );


			$('#example').DataTable( {
		        dom: "B<clear>frtip",
						bSortClasses: false,
						"bLengthChange": false,
						ajax: {
		            url: "<?=base_url()?>replies/data",
		            type: "POST"
		        },

		        serverSide: true,
		        serverSide : true,
						processing: true,
						oLanguage: {
		        sProcessing: "<img width='15%' src='<?=$asset_url?>/images/ajax-loader.gif'>"
		        },
		       columns: [
						 { data: "id"},
						 { data: "search_id", render:function(data){
							 if(search[data]) return search[data];
							 return "Deleted";
						 }},
						 {
                data: "image",
                render: function ( file_id ) {
                    return file_id ?
                        '<img src="'+editor.file( 'files', file_id ).web_path+'"/>' :
                        null;
                },
                defaultContent: "No image",
                title: "Image"
            },
				     { data: "reply"},

						 { data : "last_updated"}
		      ],
		      buttons: [
						{ extend: "create",   editor: editor },
						{ extend: "edit",   editor: editor },
						{ extend: "remove",   editor: editor },
          ],
						select: true,


		        "iDisplayLength": 100
			} );


		 });

		 function getStateList() {
			 var aStateList = new Array();

			 <?php foreach($search as $key => $value){ ?>
				aStateList[<?=$key?>] = { "label": "<?=substr($value->product_name, "0", "25")?>", "value": "<?=$value->id?>" };
       <?php } ?>

				return aStateList;

     }


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

	       <table id="example" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th style="text-align:center;">No</th>
							<th style="text-align:center;">Search Query</th>
							<th style="text-align:center;">Reply Image</th>
							<th style="text-align:center;">Reply</th>

							<th style="text-align:center;width:50%">Last Updated</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th style="text-align:center;">No</th>
							<th style="text-align:center;">Search Query</th>
								<th style="text-align:center;">Reply Image</th>
							<th style="text-align:center;">Reply</th>

							<th style="text-align:center;width:50%">Last Updated</th>
						</tr>
					</tfoot>
				</table>
	    </div>
	   </div>
	 </div>

	</body>

	<link rel="stylesheet" type="text/css" href="<?=$asset_url?>/css/bootstrap.min.css">

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

	</html>
