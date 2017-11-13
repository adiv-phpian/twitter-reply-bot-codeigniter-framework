<?php

$base_url = base_url();
$asset_url = $base_url.'/assets/';

?>


<?php
$old_password = array(
 'name'	=> 'old_password',
 'id'	=> 'old_password',
 'value' => set_value('old_password'),
 'size' 	=> 30,
 'class' => 'dark'
);
$new_password = array(
 'name'	=> 'new_password',
 'id'	=> 'new_password',
 'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
 'size'	=> 30,
 'class' => 'dark'
);
$confirm_new_password = array(
 'name'	=> 'confirm_new_password',
 'id'	=> 'confirm_new_password',
 'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
 'size' 	=> 30,
 'class' => 'dark'
);
?>

<body>
  <header>
        <?php $this->load->view("common/header.php"); ?>
    </header>

<main class="page-dashboard-settings white">

        <div class="full-page">
            <?php if($this->session->flashdata()): ?>
            <div class="row" style="border: 1px solid #d0d0d0;">
             <span style="color: green;font-size:14px;"><?php echo $this->session->flashdata('message'); ?></span>
             <span style="color: green;font-size:14px;"><?php echo $this->session->flashdata('success'); ?></span>
             <span style="color: red;font-size:14px;"><?php echo $this->session->flashdata('error'); ?></span>
            </div>
            <?php endif; ?>
            <div class="row">
                <h2>Email address</h2>
                <span class="green"><?=$user->email?></span>
            </div>

            <div class="row">

              <?php echo form_open("", array("class" => "group")); ?>
                  <div class="floater">
                    <?php echo form_label('Old Password', $old_password['id']); ?>
                    <?php echo form_password($old_password); ?>
                    <span style="color: red;font-size:10px;"><?php echo form_error($old_password['name']); ?><?php echo isset($errors[$old_password['name']])?$errors[$old_password['name']]:''; ?></span>
                  </div>
                    <div class="floater">
                      <?php echo form_label('New Password', $new_password['id']); ?>
                      <?php echo form_password($new_password); ?>
                      <span style="color: red;font-size:10px;"><?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?></span>
                    </div>

                    <div class="floater">
                      <?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?>
                      <?php echo form_password($confirm_new_password); ?>
                      <span style="color: red;font-size:10px;"><?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?></span>
                    </div>

                    <div class="floater">
                        <input type="submit" value="Update" class="gradient" />
                    </div>
                </form>
            </div>




        </div>

    </main>
