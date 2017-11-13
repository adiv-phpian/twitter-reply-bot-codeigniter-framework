  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>

<script>
var base_url = "<?=base_url()?>";

$(function () {


 Highcharts.stockChart('container', {

    navigator: {
        series: {
            color: '#FF00FF',
            lineWidth: 2
        }
    },
    title: {
        text: 'Tweets timeline with keywords'
    },

    rangeSelector: {
        selected: 1
    },

    series: [
    <?php foreach($products_stat as $stat){ ?>

    {
        name: "<?=$stat['name']?>",
        data: <?=$stat['points']?>
    },
    <?php } ?>
    ],
    credits:{
      enabled: false
    }
  });
  });

</script>
