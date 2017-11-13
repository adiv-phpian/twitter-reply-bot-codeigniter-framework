Welcome to <?php echo $site_name; ?>,

Thanks for joining <?php echo $site_name; ?>. Your
login details are below.

<?php echo site_url('/auth/login/'); ?>

<?php if (strlen($username) > 0) { ?>

Your username: <?php echo $username; ?>
<?php } ?>

Your email address: <?php echo $email; ?>

<?php /* Your password: <?php echo $password; ?>

*/ ?>

Have fun!
The <?php echo $site_name; ?> Team
