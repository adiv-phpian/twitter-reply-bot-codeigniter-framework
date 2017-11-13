<?php


if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
		'class' => "dark"
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => "dark"
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'class' => "dark"
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,

);
?>


<body>
    <header>
        <div class="container">
            <img src="<?=$asset_url?>images/logo.png" />

            <div class="menu"></div>
            <div class="right">
                <a href="<?=$base_url?>support">Support</a>
                <span><a class="button gradient" href="<?=$base_url?>login">Login</a></span>
            </div>
        </div>
    </header>

  <main class="page-dashboard-login">
    <content>
             <div class="modal frame modal-footer">
                <div class="center">
                    <img src="<?=$asset_url?>images/logo-large.png" />
                    <div class="subtitle grey">Sign up</div>
                    <hr class="small" />
										<div class="grey">Have account? <a href="<?=$base_url?>login">Login</a></div>

                 </div>

               <?php echo form_open($this->uri->uri_string()); ?>


								<?php if ($use_username) { ?>
									<label for="subject">Username</label>
	                <?php echo form_input($username); ?>
									<span style="color: red;"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?></span>
								<?php } ?>

									<?php echo form_label('Email Address', $email['id']); ?>
									<?php echo form_input($email); ?>
									<span style="color: red;"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?></span>

									<?php echo form_label('Password', $password['id']); ?>
									<?php echo form_password($password); ?>
									<span style="color: red;"><?php echo form_error($password['name']); ?></span>

								  <?php echo form_label('Confirm Password', $confirm_password['id']); ?></td>
									<?php echo form_password($confirm_password); ?>
									<span style="color: red;"><?php echo form_error($confirm_password['name']); ?></span>

                 <?php if ($captcha_registration) {
											if ($use_recaptcha) { ?>
										<tr>
											<td colspan="2">
												<div id="recaptcha_image"></div>
											</td>
											<td>
												<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
												<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
												<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="recaptcha_only_if_image">Enter the words above</div>
												<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
											</td>
											<td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
											<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
											<?php echo $recaptcha_html; ?>
										</tr>
										<?php } else { ?>
										<tr>
											<td colspan="3">
												<p>Enter the code exactly as it appears:</p>
												<?php echo $captcha_html; ?>
											</td>
										</tr>
										<tr>
											<td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
											<td><?php echo form_input($captcha); ?></td>
											<td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
										</tr>
										<?php }
										} ?>


								<?php echo form_submit('submit', 'Sign up', array("class" => "gradient")); ?>
								<?php echo form_close(); ?>

                <div class="modal-footer-links">
                    <a href="<?=$base_url?>privacy">Privacy</a> and <a href="<?=$base_url?>terms">Terms</a>
                </div>
            </div>

        </content>

		</main>
