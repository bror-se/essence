<?php
/**
 * Essence admin functions
 *
 * @package Wordpress
 * @subpackage Essence
 */

/**
 * Check to see if the tagline is set to default
 * Show an admin notice to update if it hasn't been changed
 * You want to change this or remove it because it's used as the description in the RSS feed
 */
if ( get_option( 'blogdescription' ) === 'Just another WordPress site' ) {
  add_action( 'admin_notices', create_function( '', "echo '<div class=\"error\"><p>" . sprintf(__( 'Please update your <a href="%s">site tagline</a>', THEME_NAME ), admin_url( 'options-general.php' )) . "</p></div>';" ) );
};

/**
 * Set the post revisions to 5 unless the constant
 * Was set in wp-config.php to avoid DB bloat
 */
if ( !defined( 'WP_POST_REVISIONS' ) ) define( 'WP_POST_REVISIONS', 5 );

/**
 * Allow more tags in TinyMCE including iframes
 */
function essence_add_mce_options( $options ) {
  $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';
  if ( isset( $initArray['extended_valid_elements'] ) ) {
    $options['extended_valid_elements'] .= ',' . $ext;
  } else {
    $options['extended_valid_elements'] = $ext;
  }
  return $options;
}
add_filter( 'tiny_mce_before_init', 'essence_add_mce_options' );

/**
 * Remove dashboard widgets
 * http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
 */
function essence_remove_dashboard_widgets() {
  remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
}
add_action( 'admin_init', 'essence_remove_dashboard_widgets' );

?>