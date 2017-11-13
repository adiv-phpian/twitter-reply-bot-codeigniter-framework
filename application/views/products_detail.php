<body>
  <header>

		<script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

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

          .ul-graphs li{
            list-style-type: none;
            padding: 10px;
          }

					table th, td{
						padding: 5px;
						border: 1px solid #d0d0d0;
						text-align: center;
					}

        </style>
    </header>

    <main class="page-dashboard" >
			<div style="margin: 0 auto;">
			<?php if($product->num_rows() == 0){ ?>

      <h3 style="text-align:center;margin:0 auto;">statistics is not ready for the product yet, See after some time.</h3>

			<?php }else{ $product = $product->row(); ?>
         <h3>Statistics for Products - <?=$product->product_name?></h3>
				<table style="text-align:center;margin:0 auto;">
          <thead>
           <tr>
						 <th><a target="__blank" href="<?=base_url()?>products/tweets/all_tweets/<?=$product->product_id?>">Total Tweets Count</a></th>

					 </tr>
					</thead>
           <tbody>
            <tr>
							<td><?=$product->tweet_count?></td>

						</tr>
						<tr><td colspan="3">Updated on: <?=$product->datetime?></td></tr>
					 </tbody>
				</table>
       <?php if($product_stat->num_rows() > 0){ $stat = $product_stat->row(); ?>
        <content>
          <ul style="width:800px;" class="ul-graphs">
            <li>
              <h2>Intent Timeline</h2>
                <div>
                  <div id="container"></div>
                </div>
              </li>
            <li>

            <div>
              <div id="container" style="min-width: 310px; max-width: 900px; margin: 0 auto"></div><br>
            </div>
            <br>
            <div style="font-size:12px;">
            Data generated on <?=$stat->datetime?>
            </div>
            </li>
            <li>
             <script src="https://code.highcharts.com/modules/exporting.js"></script>
             <div id="container3" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
            </li>
            <li>
              <script src="https://code.highcharts.com/modules/exporting.js"></script>
              <div id="container5" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            </li>
          </ul>

        </content>

				<?php } ?>
			 </div>
			<?php } ?>
      </main>


    <script>

      $(function () {

			var usdeur = <?=$points?>;
			var usdeur1 = <?=$points1?>;
			var usdeur2 = <?=$points2?>;

			 Highcharts.stockChart('container', {

					navigator: {
							series: {
									color: '#FF00FF',
									lineWidth: 2
							}
					},

					rangeSelector: {
							selected: 1
					},

					series: [{
							name: 'Tweets',
							data: usdeur
					}],
          credits:{
            enabled: false
          }
			});

		});
  </script>
