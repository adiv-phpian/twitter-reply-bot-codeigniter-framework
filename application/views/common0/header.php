<body>

  <header>
        <div class="container">
          <span style="font-size:24px;">Lucy
            <span style="font-size: 12px; margin-top: -10px;">I am a twitter bot!</span>
          </span>
            <div class="menu"></div>
            <div class="right">
                <?php echo anchor('/dashboard', 'Dashboard'); ?>
                <?php echo anchor('/replies', 'Replies'); ?>
                <?php echo anchor('/tweets', 'Tweets'); ?>
                <?php echo anchor('/products', 'Search Terms'); ?>
                <?php echo anchor('/auth/logout/', 'Logout'); ?>
            </div>
        </div>
    </header>
