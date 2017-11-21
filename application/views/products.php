<?php $asset_url = str_replace("index.php/", "", base_url()).'assets/'; ?>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?=$asset_url?>/css/editor.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?=$asset_url?>/resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="<?=$asset_url?>assets/resources/demo.css">
	<style type="text/css" class="init">

	</style>
	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
	</script>
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
  </style>

	<script type="text/javascript" language="javascript" class="init">
  var base_url = "<?=base_url()?>";
  var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {
	editor = new $.fn.dataTable.Editor( {
		ajax: "<?=base_url()?>products/data",
		table: "#example",
		fields: [ {
				label: "Keyword or username:",
				name: "product_name"
			},

		]
	} );

	$('#example').DataTable( {
		dom: "B<clear>frtip",

		lengthMenu: [ 10, 25, 50, 75, 100 ],
		bSortClasses: false,
		ajax: {
				url: "<?=base_url()?>products/data",
				type: "POST"
		},
		processing: true,
		oLanguage: {
		sProcessing: "<img width='15%' src='<?=$asset_url?>/images/ajax-loader.gif'>"
		},
		serverSide: true,
		serverSide : true,
		columns: [

			{ data: "product_name", render: function ( pname, type, row ) {
				 //var obj = JSON.stringify(tweet);
         return '<a target="__blank" href="'+base_url+'products/product/'+row.id+'">'+pname+'</a>';
			} },

			{ data: "last_search" },
      { data: "added_date" },

		],
		select: true,
		buttons: [
			{ extend: "create", editor: editor },
			{ extend: "edit",   editor: editor },
			{ extend: "remove", editor: editor }
		]
	} );
} );



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
						<th>Keyword</th>

						<th>Last search </th>
            <th>Added Date </th>
					</tr>
				</thead>
				<tfoot>
					<tr>
            <th>Keyword</th>

						<th>Last search </th>
            <th>Added Date </th>
					</tr>
				</tfoot>
			</table>
    </div>
   </div>
 </div>

</body>
</html>
