<!DOCTYPE html>
<html>
<head>
    <title><?=$title?> DMPilot</title>

    <meta charset="utf-8" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="stylesheet" href="<?=$asset_url?>styles/application.css" type="text/css" media="screen, handheld, projection">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <style>
    .check{
      cursor: pointer;
    }

    .content{
      min-height: 150px;
    }

    .content span.description{
      margin-bottom: 0px;
    }

    .dashboard-note{
      max-width: 80%;
      text-align: center;
      font-size: 13px;
      border-top: 1px solid #f2f2f2;
      padding-top: 20px;
      margin-top: 20px;
      color: #8e8e8e;
    }
    </style>

   <?php if($this->session->userdata("user_id")){ ?>
    <script>


    //Menu
    var menu = {

        init: function () {
            $("#mobilemenu").on("click", function (e) {
              console.log("new");
                e.preventDefault();
                if (!$(this).hasClass("open")) {
                    $("#menu").slideDown();
                } else {
                    $("#menu").slideUp();
                }
                $(this).toggleClass("open");
            })
        }
    };


    var trialRemainingDays = <?php $datediff = strtotime("now")-strtotime($subscription->created_at);
                                  $trialRemainingDays = 14 - floor($datediff / (60 * 60 * 24));
                                   echo $trialRemainingDays;
                             ?>;

    var trial_period = true;

    <?php if($subscription->status == "active"){ ?>
      var trial_period = false;
    <?php } ?>


    var pay = false;

    <?php if($trialRemainingDays < 1 && $subscription->status != "active"){ ?>
      pay = true;
    <?php } ?>




    var email = "<?=$subscription->email?>";

    var baseUrl = "<?=base_url()?>";
    var assetUrl = "<?=$asset_url?>";
    var userId = "<?=$user->user_id?>";
    var next_billing_date = "<?=date("d-m-Y", strtotime($subscription->next_bill_date))?>";


    if(pay){
      var paddle_vendor_id = <?=$this->config->item("paddle_vendor_id")?>;
      var paddle_yearly_product_id = <?=$this->config->item("paddle_yearly_product_id")?>;
      var paddle_monthly_product_id = <?=$this->config->item("paddle_monthly_product_id")?>;
    }

    $(function(){



      <?php if($this->session->userdata("user_id")){ ?>
        $(".menu").append("<li><a href='"+baseUrl+"auth/logout'>Logout</a></li>");
        $(".menu-link-<?=$page?>").addClass("active");
       <?php }else{ ?>
         $(".menu-link-dashboard").addClass("active");
       <?php } ?>


    });

    </script>

    <script src="https://cdn.paddle.com/paddle/paddle.js"></script>
    <script src="<?=$asset_url?>scripts/application.js"></script>

    <?php } ?>

    <script>
    $(function(){
      $("#mobilemenu").on("click", function (e) {
    
          e.preventDefault();
          if (!$(this).hasClass("open")) {
              $("#menu").slideDown();
          } else {
              $("#menu").slideUp();
          }
          $(this).toggleClass("open");
      })
    });
    </script>



  </head>
  <body id="main_body" style="display:none;">
      <div class="page">
           <header>
              <div class="container">
                  <img class="logo" src="<?=$asset_url?>images/logo.svg" />

                  <a href="javascript:void(0);" class="mobile-menu visible-tablet-down" id="mobilemenu">
                      <span></span><span></span><span></span><span></span>
                  </a>

                  <ul class="menu" id="menu">
                      <li><a href="<?=base_url()?>" class="menu-link-dashboard">Your Auto DMs</a></li>
                      <li><a class="menu-link-settings" href="settings">Settings</a></li>
                      <li><a href="mailto:support@dmpilot.com" target="__blank">Contact</a></li>
                  </ul>
              </div>
          </header>
