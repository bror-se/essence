<?php
/**
 * The template for displaying search forms in Essence
 *
 * @package WordPress
 * @subpackage Essence
 */
?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <label for="s" class="visuallyhidden"><?php _e( 'Search', THEME_NAME ); ?></label>
  <input type="text" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', THEME_NAME ); ?>" />
  <input type="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', THEME_NAME ); ?>" />
</form>