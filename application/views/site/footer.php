
  <footer>
      An LEJC Digital Ltd Product | We're Not Affiliated with Twitter
  </footer>
  </body>

  <?php if($this->session->userdata("user_id")){ ?>

  <div class="popup-wrapper">
      <div class="popup">
          <div class="title"></div>
          <div class="message" style="margin-bottom: -10px;"></div>

          <div id="notify" style="color:#0d0d0d0;font-size: 12px; padding: 5px; margin: 15px;"></div>

          <div id="subscription_popup">
            <div class="button large strong agree" style="border: 3px solid #63a8f1;"></div>
            <div class="button large strong outline disagree"></div>
          </div>

          <div id="email_popup">
            <div class="input">
              <input type="text" id="fullname" placeholder="Your Name" value="<?=$user->fullname?>" />
              <input type="text" id="email" placeholder="Your Email Address" value="<?=$user->email?>" />
            </div>
            <div class="button large strong agree"></div>
            <div class="button large strong outline disagree" style="display:none;"></div>
          </div>

      </div>
  </div>

  <?php } ?>

  <script>
   $(function(){
     $("#main_body").fadeIn("slow");
   });
  </script>


 </html>
