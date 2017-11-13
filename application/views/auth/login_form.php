<?php

$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => "dark"
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or login';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
	'class' => 'dark'
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
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
                <span><a class="button gradient" href="<?=$base_url?>register">Claim your Free Trail</a></span>
            </div>
        </div>
    </header>

  <main class="page-dashboard-login">
    <content>
             <div class="modal frame modal-footer">
                <div class="center">
                    <img src="<?=$asset_url?>images/logo-large.png" />
                    <div class="subtitle grey">Sign in</div>
                    <hr class="small" />
                    <div class="grey">Don't have an account yet? <a href="<?=$base_url?>auth/register">Sign up</a></div>
                 </div>

               <?php echo form_open($this->uri->uri_string()); ?>
                <label for="subject">Username Or Email</label>
                <?php echo form_input($login); ?>
								<span style="color: red;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></span>

                <label for="password">Password</label>
                <?php echo form_input($password); ?>
								<span style="color: red;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?></span>

								<?php if ($show_captcha) {
									if ($use_recaptcha) { ?>
										<div class="form-group">
					        			<div id="recaptcha_image"></div>

					        			<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
					        			<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
					        			<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>

					        			<div class="recaptcha_only_if_image">Enter the words above</div>
					        			<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
										</div>
					          <div class="form-group">
					        		<input type="text" id="recaptcha_response_field" class="form-control" name="recaptcha_response_field" /></td>
					        		<span style="color:red;"><?php echo form_error('recaptcha_response_field'); ?></span>
					        		<?php echo $recaptcha_html; ?>
					          </div>

								<?php } else { ?>
									<div class="form-group">
		        			<p>Enter the code exactly as it appears</p>
		        			<?php echo $captcha_html; ?>
		        		</td>
		        	</div>
		          <div class="form-group">
		        		<?php echo form_input($captcha, "", array("class" => "form-control",  "placeholder" => "Captcha Code")); ?>
		        		<span style="color: red;"><?php echo form_error($captcha['name']); ?></span>
						  </div>
								<?php }
								} ?>

								<!--<?php echo form_checkbox($remember); ?>
								<?php echo form_label('Remember me', $remember['id']); ?> -->


								<?php echo form_submit('submit', 'Login', array("class" => "gradient")); ?>
								<?php echo form_close(); ?>

								<?php echo anchor('/forgot_password/', 'Forgot password'); ?>

                <div class="modal-footer-links">
                    <a href="<?=$base_url?>privacy">Privacy</a> and <a href="<?=$base_url?>terms">Terms</a>
                </div>
            </div>

        </content>


    </main>
