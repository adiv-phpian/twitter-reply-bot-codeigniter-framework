<!DOCTYPE html>
<html>
<head>
    <title>Exportify - Export Your FreeAgent Data (Including
Receipts).</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Exportify - Export Your FreeAgent Data (Including
Receipts). Finally Export your FreeAgent Data (Including Receipts and Attachments)">
    <meta name="keywords" content="Exportify - Export Your FreeAgent Data (Including
Receipts).Finally Export your FreeAgent Data (Including Receipts and Attachments)">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@exportify">
    <meta name="twitter:title" content="Exportify - Export Your FreeAgent Data (Including
Receipts).">
    <meta name="twitter:description" content="Finally Export your FreeAgent Data
(Including Receipts and Attachments)">
    <meta name="twitter:creator" content="@exportify">

    <meta name="twitter:image" content="<?=base_url()?>assets/images/logo-big.png">

    <!-- Open Graph data -->
    <meta property="og:title" content="Exportify - Export Your FreeAgent Data (Including
Receipts)." />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?=base_url()?>" />
    <meta property="og:image" content="<?=base_url()?>assets/images/logo.png" />
    <meta property="og:description" content="Exportify - Export Your FreeAgent Data (Including
Receipts)." />
    <meta property="og:site_name" content="Exportify" />


    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="<?=$asset_url?>stylesheet/StyleSheet.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="<?=$asset_url?>javascript/application.js"></script>
</head>

<body class="landing-page">

    <header>
        <div class="container">
            <a href="<?=$base_url?>"><img src="<?=$asset_url?>images/logo-big.png" /></a>

            <div class="menu"></div>
            <div class="right">
                <a href="javascript:;" onclick="goToByScroll('features')">How it Works</a>
                <a href="javascript:;" onclick="goToByScroll('prices')">Pricing</a>
                <span><a class="button gradient" href="<?=$base_url?>register">Claim your Free Trial</a></span>
                <a href="<?=$base_url?>login">Login</a>
            </div>
        </div>
    </header>


    <main class="top">

        <img src="<?=$asset_url?>images/logo-big.png" />
        <div class="slogan">
          Finally Export your FreeAgent Data<br />(Including Receipts and Attachments)
            <div class="small grey">  <a href="<?=$base_url?>register" style="font-size: 25px;vertical-align:middle;padding: 10px;" class="gradient button">Get Started</a></div>
        </div>

        <div class="scroll" onclick="goToByScroll('features')"></div>
    </main>

    <content id="features" onclick="goToByScroll('features')">
        <div class="blocks group">
            <div class="block center">
                <div class="image">
                    <img src="<?=$asset_url?>images/step1.png" />
                </div>
                <span class="green">Step 1</span>

                <div class="title">Connect to FreeAgent</div>

                <div class="desc">

                      All you need to do is connect your<br /> FreeAgent account to Exportify and you’re<br /> ready to go!
                </div>

            </div>

            <div class="block center">
                <div class="image">
                    <img src="<?=$asset_url?>images/step2.png" />
                </div>
                <span class="green">Step 2</span>

                <div class="title">Set your email address</div>

                <div class="desc">
                    Receive a backup directly into your inbox<br /> or log into Exportify and download an <br /> instant backup.
                </div>

            </div>

            <div class="block center">
                <div class="image">
                    <img src="<?=$asset_url?>images/step3.png" />
                </div>
                <span class="green">Step 3</span>

                <div class="title">Receive a regular feed</div>

                <div class="desc">
                    Every week or month, you decide, <br />  we’ll email you an up to date back up<br /> of your FreeAgent data including every receipt.
                </div>
            </div>
        </div>
    </content>

    <main class="bottom" id="prices" onclick="goToByScroll('prices')">

        <div class="title"></div>

        <div class="card">

            <div class="head">
                <div class="currency">
                    <span class="prefix">&pound;</span>5
                </div>
                <div class="grey">
                    /month, VAT included
                </div>
            </div>
            <ul>
                <li>7 day FREE trial included</li>
                <li>
                    Automatically receive a<br />
                    backup via email
                </li>
                <li>
                    Unlike FreeAgent all<br />
                    attachments will be included
                </li>
                <li>
                    Cancel at any time
                </li>
            </ul>
            <a href="<?=$base_url?>register" style="font-size: 25px;vertical-align:middle;" class="gradient button">Start your Free Trial</a>
        </div>
    </main>

    <script>
     $(function(){

     });

     function goToByScroll(id, scroll = "0"){

      // Remove "link" from the ID
      id = id.replace("link", "");
      // Scroll
      $('html,body').animate({
        scrollTop: $("#"+id).offset().top},
        'slow');
     }
    </script>
        <footer>
            &copy; Exportify <?=date("Y")?> <a href="<?=$base_url?>privacy">Privacy</a> and <a href="<?=$base_url?>terms">Terms</a>
            <p><a href="https://lejcdigital.com" target="_blank">LEJC Digital Ltd</a> Trading as Exportify<br/>Company Registered in England and Wales GB221800847 at 20-22 Wenlock Road, London, N1 7GU</p>
        </footer>
    </body>
    </html>
