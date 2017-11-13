
<?php

$asset_url = base_url().'assets/';

 ?>
<!DOCTYPE html>
<html>
<head>
    <title>Lucy, I am a twitter bot.</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="<?=$asset_url?>stylesheet/StyleSheet.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="<?=$asset_url?>javascript/application.js"></script>
</head>

<body>

  <main class="page-dashboard-login" style="background: none;">
    <content>
             <div class="modal frame modal-footer">
                <div class="center">

                    <div class="subtitle grey">Hi, I am Lucy. I am a twitter bot.</div>
                    <hr class="small" />
                    <div class="grey">Sigin with your twitter account to continue<br><a style="font-size: 20px; cursor: pointer;" href="<?=base_url()?>auth/login">Click here to sign in</a></div>
                 </div>
                <div class="modal-footer-links">

                </div>
            </div>

        </content>

    </main>

</body>
</html>
