<?php

$base_url = base_url();
$asset_url = $base_url.'/assets/';

$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'class' => "dark"
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
	'class' => "dark"
);
?>

<header>
		<div class="container">
				<a href="<?=$base_url?>"><img src="<?=$asset_url?>images/logo.png" /></a>

				<div class="menu"></div>
				<div class="right">

				</div>
		</div>
</header>

<main class="page-dashboard-login">
	<content>
					 <div class="modal frame modal-footer">
							<div class="center">
									<img src="<?=$asset_url?>images/logo-large.png" />
									<div class="subtitle grey">Reset Password</div>
									<hr class="small" />

							 </div>
              <?php echo form_open($this->uri->uri_string()); ?>
							<?php echo form_label('New Password', $new_password['id']); ?>
							<?php echo form_password($new_password); ?>
							<span style="color: red;font-size: 10px;"><?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?></span>

							<?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?>
							<?php echo form_password($confirm_new_password); ?>
							<span style="color: red;font-size: 10px;"><?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?></span>


							<?php echo form_submit('Reset', 'Change Password', array("class" => "gradient")); ?>
							<?php echo form_close(); ?>

					</div>

			</content>
</main>
