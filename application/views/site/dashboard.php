
<?php $this->load->view("site/header"); ?>

<script>
  var settings = <?=$user->dm_settings?>;

  $(function(){
      if(trial_period){
        if(parseInt(trialRemainingDays) > 0){
          $("#container_div").prepend('<div style="font-weight: 600;margin-bottom: 10px;text-transform:uppercase;font-size: 16px;margin: 0 auto; text-align:center; color: #63a8f1; padding: 5px; max-width: 45%;">You have '+trialRemainingDays+' days remaining on your free trial </div>');
        }else{
          $("#container_div").prepend('<div style="font-weight: 600;margin-bottom: 10px;text-transform: uppercase;font-size: 16px;margin: 0 auto; text-align:center; color: #63a8f1; padding: 5px; max-width: 45%;">Your trial period is over. </div>');
        }
      }else{
          $("#container_div").prepend('<div style="font-weight: 600;margin-bottom: 10px;text-transform: uppercase;font-size: 16px; margin: 0 auto; text-align:center; color: #63a8f1; padding: 5px; max-width: 45%;">Your next billing date is '+next_billing_date+'. </div>');
      }
    });

</script>

        <content>
            <div class="container" id="container_div">
                <div style="margin: 0auto; text-align: center; margin-bottom: 0; font-size: 15px;">Press the tick to turn on that DM type. When the tick is blue, that message type is turned on</div>
                <div class="dashboard">


                    <div class="info-box-wrapper followed">
                        <div class="info-box">
                            <div class="title">
                                People who have recently followed you
                                <span class="check-followed check" ><img src="<?=$asset_url?>images/check.svg" /></span>
                            </div>
                            <div class="content">
                                <textarea class="disabled-text-followed" disabled>This is a direct message that is sent to anyone who follows you. It’s a great way to say hello and to introduce yourself.</textarea>
                                <textarea class="message-followed" id="message-followed" placeholder="Enter your direct message here." ></textarea>
                                <div class="button-wrapper">
                                    <input class="update-followed" type="button" value="Update" />
                                    <span class="description"><?php if($counts[1] > 0){ echo $counts[1].' DMs sent so far '; }else{ echo 'No DMs sent yet'; } ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-box-wrapper">
                        <div class="info-box">
                            <div class="title">
                                People who have mentioned you
                                <span class="check-mentioned check"><img src="<?=$asset_url?>images/check.svg" /></span>
                            </div>
                            <div class="content">
                                <textarea class="disabled-text-mentioned" disabled>Use this to drop someone who mentioned you a direct message to show some appreciation.</textarea>
                                <textarea class="message-mentioned" placeholder="Enter your direct message here."></textarea>
                                <div class="button-wrapper">
                                    <input class="update-mentioned" type="button" value="Update" />
                                    <span class="description"><?php if($counts[2] > 0){ echo $counts[2].' DMs sent so far '; }else{ echo 'No DMs sent yet'; } ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-box-wrapper">
                        <div class="info-box">
                            <div class="title">
                                People who have replied to your tweets
                                <span class="check-replied check"><img src="<?=$asset_url?>images/check.svg" /></span>
                            </div>
                            <div class="content">
                                <textarea class="disabled-text-replied" disabled>Use this to drop someone who mentioned you a direct message to show some appreciation.</textarea>
                                <textarea class="message-replied" placeholder="Enter your direct message here."></textarea>
                                <div class="button-wrapper">
                                    <input class="update-replied" type="button" value="Update" />
                                    <span class="description"><?php if($counts[3] > 0){ echo $counts[3].' DMs sent so far '; }else{ echo 'No DMs sent yet'; } ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-box-wrapper">
                        <div class="info-box">
                            <div class="title">
                                People who have added you to a list
                                <span class="check-listed check"><img src="<?=$asset_url?>images/check.svg" /></span>
                            </div>
                            <div class="content">
                                <textarea class="disabled-text-listed" disabled>If you want to say thank you for being added to a Twitter user’s list, then use this direct message.</textarea>
                                <textarea class="message-listed" placeholder="Enter your direct message here."></textarea>
                                <div class="button-wrapper">
                                    <input class="update-listed" type="button" value="Update" />
                                    <span class="description"><?php if($counts[4] > 0){ echo $counts[4].' DMs sent so far '; }else{ echo 'No DMs sent yet'; } ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-box-wrapper">
                        <div class="info-box">
                            <div class="title">
                                People who liked a tweet
                                <span class="check-liked check"><img src="<?=$asset_url?>images/check.svg" /></span>
                            </div>
                            <div class="content">
                                <textarea class="disabled-text-liked" disabled>If a user likes one of your tweets, you can send them a direct message to say thanks.</textarea>
                                <textarea class="message-liked" placeholder="Enter your direct message here."></textarea>
                                <div class="button-wrapper">
                                    <input class="update-liked" type="button" value="Update" />
                                    <span class="description"><?php if($counts[5] > 0){ echo $counts[5].' DMs sent so far '; }else{ echo 'No DMs sent yet'; } ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-box-wrapper">
                        <div class="info-box">
                            <div class="title">
                                People who retweeted a tweet
                                <span class="check-retweeted check"><img src="<?=$asset_url?>images/check.svg" /></span>
                            </div>
                            <div class="content">
                                <textarea class="disabled-text-retweeted" disabled>Say thank you to a user who retweeted you using this direct message. This is a great opportunity to promote your blog to someone who has interacted with your brand already.</textarea>
                                <textarea class="message-retweeted" placeholder="Enter your direct message here."></textarea>
                                <div class="button-wrapper">
                                    <input class="update-retweeted" type="button" value="Update" />
                                    <span class="description"><?php if($counts[6] > 0){ echo $counts[6].' DMs sent so far '; }else{ echo 'No DMs sent yet'; } ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <span class="dashboard-note" style="">Please note, DM Pilot will only send automated messages to people who follow you.
We also have several time restrictions in place to avoid spamming Twitter users.</span>
                </div>
            </div>
        </content>
      </div>

  <?php $this->load->view("site/footer"); ?>
