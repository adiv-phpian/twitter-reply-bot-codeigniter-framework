<body style="overflow-x: hidden;">
  <?php $twitter_user = json_decode($user->user_json); //print_r($twitter_user->profile_image_url);die; //print_R("<pre>");print_R($twitter_user);print_R("</pre>");die; ?>
  <header>

    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

      <?php $this->load->view("common/header"); ?>

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

        </style>
    </header>

    <main class="page-dashboard">

        <div class="" style="width: 270px;padding: 40px 30px 125px 30px;">
           <span style="">Connected account</span><br>
           <span class="green"><img src="<?=$twitter_user->profile_image_url?>"></span>
            <span class="green"><a href="https://twitter.com/<?=$twitter_user->screen_name?>" target="__blank">@<?=$twitter_user->screen_name?></a></span>
            <br>
            <p class="small">
               <?php echo anchor('/auth/login?force_login=true', 'Change account'); ?>
            </p>
            <span style="font-size: 12px;">Last login <br><?=date("H:i:s d-m-y", strtotime($user->last_login))?></span>
            </p>
            <hr />
        </div>

        <content style="margin-left: 17em; margin-top: -24em;">
          <ul style="width:800px;" class="ul-graphs">
            <li>
              <h2><button type="button" style="font-size: 10px;float:right;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Configuration</button></h2>

                <div>
                  <div id="container"></div>
                </div>
              </li>

            <li>

            <div>

              <div id="container1" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div><br>

            </div>
            <br>

            </li>

          </ul>

        </content>
      </main>


      <script>
        var base_url = "<?=base_url()?>";
        $(function () {


            Highcharts.chart('container1', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Tweets Count for every keyword'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: [<?=implode(",", $graph1['names'])?>],
                    title: {
                        text: null
                    },
                    labels: {
                        formatter: function () {
                        return '<a style="cursor:pointer;" target="__blank" href="'+base_url+'products/product/'+encodeURIComponent(this.value)+'">' + this.value + '</a>'
                    },
                useHTML: true
                }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: '% or Counts',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                    valueSuffix: ' '
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 80,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                    shadow: true
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Tweets',
                    data: [<?=implode(",", $graph1['tweet_counts'])?>]
                }]
            });


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
            <?php foreach($graph2 as $key => $stat){ ?>

            {
                name: "<?=$key?>",
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


    <!-- Modal -->
     <div class="modal fade" id="myModal" role="dialog">
       <div class="modal-dialog">

         <!-- Modal content-->
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title">Settings for Graphs</h4>
           </div>
           <div class="modal-body">
             <div class="container">

             <form id="form">
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
                <p class="pull-left">Choose keywords that should appear on graphs.</p><br>
                <ul class="checkbox-grid"> </ul>

             <?php $i = 0; if($products->num_rows() > 0){
               foreach($products->result() as $product){ ?>
                  <?php if($i == 0){ ?> <ul class="checkbox-grid"> <?php } ?>
                    <li><input name="dashboard_options[]" <?php if(in_array($product->product_name, $dashboard_options)) echo "checked"; ?> id="text<?=$product->id?>" type="checkbox" value="<?=$product->product_name?>" />&nbsp;<label for="text<?=$product->id?>"><?=substr($product->product_name, "0", "20")?></label></li>
                 <?php $i++; if($i > 2){ ?> </ul> <?php $i = 0; } ?>
                <?php   }  }else{ ?>
                   No products added or not graph data update. Please revisit after few hours.
                 <?php } ?>
           </div>
         </div>
         </form>
           <div class="modal-footer" >
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             <button type="button" class="btn btn-primary" id="save">Save</button>
           </div>
         </div>

       </div>
     </div>


     <script>
      $(function(){
        $("#save").click(function(){
          //$(this).attr("disabled", "true");
          $(this).html("Saving...");

          var get = $.post("<?=base_url()?>dashboard/save_graph_options", $("#form").serialize());

          get.done(function(data){
              //$(this).removeAttr("disabled");
              $(this).html("Save");
              $("#myModal").modal("hide");
              window.location.reload();
          });

          get.fail(function(data){
             //$(this).removeAttr("disabled");
             $(this).html("Save");
             alert("something went wrong try again.")
          });
        });

      });

     </script>
