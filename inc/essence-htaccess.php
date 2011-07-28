<?php
/**
 * Essence htaccess
 *
 * Add our custom htaccess to Wordpress
 *
 * @package Wordpress
 * @subpackage Essence
 */

/**
 * Add notice in admin if htaccess isn't writable
 */
function essence_htaccess_writable() {
  if ( !is_writable( get_home_path() . '.htaccess' ) ) {
    add_action( 'admin_notices', create_function( '', "echo '<div class=\"error\"><p>" . sprintf( __( 'Please make sure your <a href="%s">.htaccess</a> file is writeable ', THEME_NAME ), admin_url( 'options-permalink.php' ) ) . "</p></div>';" ) );
  };
}
add_action( 'admin_init', 'essence_htaccess_writable' );

/**
 * Write new htaccess
 */
function essence_add_h5bp_htaccess($rules) {
  global $wp_filesystem;

  if ( !defined( 'FS_METHOD' ) ) define( 'FS_METHOD', 'direct' );
  if ( is_null( $wp_filesystem ) ) WP_Filesystem( array(), ABSPATH );

  if ( !defined( 'WP_CONTENT_DIR') )
  define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );

  $theme_name = next( explode( '/themes/', get_template_directory() ) );
  $filename = WP_CONTENT_DIR . '/themes/' . $theme_name . '/inc/essence-htaccess.htaccess';

  $rules .= $wp_filesystem->get_contents( $filename );

  return $rules;
}
add_action( 'mod_rewrite_rules', 'essence_add_h5bp_htaccess' );

?>