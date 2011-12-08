<?php
/**
 * The template for displaying search forms in Essence
 *
 * @package WordPress
 * @subpackage Essence
 */
?>

<form method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
  <label for="s"><?php _e('Search', 'essence'); ?></label>
  <input type="text" name="s" id="s" placeholder="<?php esc_attr_e('Search', 'essence'); ?>" />
  <input type="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e('Search', 'essence'); ?>" />
</form>
