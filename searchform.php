<form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
  <label for="s"><?php _e('Search for:', 'essence'); ?></label>
  <input type="search" value="" name="s" id="s" placeholder="<?php _e('Search', 'essence'); ?> <?php bloginfo('name'); ?>">
  <input type="submit" id="searchsubmit" value="<?php _e('Search', 'essence'); ?>">
</form>
