<?php

$base_url = base_url();
$asset_url = $base_url.'/assets/';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Notification </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="<?=$asset_url?>stylesheet/StyleSheet.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="<?=$asset_url?>javascript/application.js"></script>
</head>
<body>

    <header>
        <div class="container">
            <a href="<?=$base_url?>">Lucy</a>

            <div class="menu"></div>
            <div class="right">
              <?php if(!$this->session->userdata("user_id")): ?>
              <a href="<?=$base_url?>login">Login</a>
              <a href="<?=$base_url?>register">Signup</a>
            <?php else: ?>
              <a href="<?=$base_url?>dashboard">Dashboard</a>
              <a href="<?=$base_url?>settings">Settings</a>
              <a href="<?=$base_url?>auth/logout">Logout</a>
            <?php endif; ?>
            </div>
        </div>
    </header>

  <main class="page-dashboard-login">
    <content>
             <div class="modal frame modal-footer">
                <div class="center">
                    <h2>Message</h2>
                    <hr class="small" />
                    <div class="grey"><?php echo $message; ?></div>
                 </div>
                <div class="modal-footer-links">

                </div>
            </div>

        </content>
  </main>
</body>
</html>
