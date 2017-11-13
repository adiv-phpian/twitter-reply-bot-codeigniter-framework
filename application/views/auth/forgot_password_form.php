<?php

$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Email or login';
} else {
	$login_label = 'Email';
}
?>


  <main class="page-dashboard-login">
    <content>
             <div class="modal frame modal-footer">
                <div class="center">

                    <div class="subtitle grey">Forgot Password</div>
                    <hr class="small" />
                    <div class="grey">Remember Password? <a href="<?=$base_url?>login">Login</a></div>
                 </div>

               <?php echo form_open($this->uri->uri_string()); ?>
                <label for="subject">Email</label>
                <?php echo form_input($login); ?>
								<span style="color: red;font-size: 10px;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></span>


								<?php echo form_submit('Reset', 'Reset Password', array("class" => "gradient")); ?>
								<?php echo form_close(); ?>

            </div>

        </content>
  </main>
