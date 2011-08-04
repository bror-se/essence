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
if ( stristr( $_SERVER['SERVER_SOFTWARE'], 'apache' ) !== false ) {
  function essence_htaccess_writable() {
    if ( !is_writable( get_home_path() . '.htaccess' ) ) {
      add_action( 'admin_notices', create_function( '', "echo '<div class=\"error\"><p>" . sprintf( __( 'Please make sure your <a href="%s">.htaccess</a> file is writeable ', THEME_NAME ), admin_url( 'options-permalink.php' ) ) . "</p></div>';" ) );
    };
  }
}
add_action( 'admin_init', 'essence_htaccess_writable' );

/**
 * Flush rewrite rules
 */
function essence_flush_rewrites() {
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}

/**
 * Set the permalink structure to /year/postname/
 */
if ( get_option( 'permalink_structure' ) != '/%year%/%postname%/' ) {
  update_option( 'permalink_structure', '/%year%/%postname%/' );
}

/**
 * Set upload folder to /assets/.
 */
update_option( 'uploads_use_yearmonth_folders', 0 );
update_option( 'upload_path', 'assets' );

/**
 * Apply rewrites (won't apply for child themes)
 */
function essence_add_rewrites( $content ) {
  $theme_name = next( explode( '/themes/', get_stylesheet_directory() ) );
  global $wp_rewrite;
  $essence_new_non_wp_rules = array(
    'css/(.*)'      => 'wp-content/themes/'. $theme_name . '/css/$1',
    'js/(.*)'       => 'wp-content/themes/'. $theme_name . '/js/$1',
    'img/(.*)'      => 'wp-content/themes/'. $theme_name . '/img/$1',
    'fonts/(.*)'    => 'wp-content/themes/'. $theme_name . '/fonts/$1',
    'plugins/(.*)'  => 'wp-content/plugins/$1'
  );
  $wp_rewrite->non_wp_rules += $essence_new_non_wp_rules;
}
add_action( 'admin_init', 'essence_flush_rewrites' );

/**
 * Apply new path to assets
 */
function essence_clean_assets( $content ) {
    $theme_name = next( explode( '/themes/', $content ) );
    $current_path = '/wp-content/themes/' . $theme_name;
    $new_path = '';
    $content = str_replace( $current_path, $new_path, $content );
    return $content;
}

/**
 * Apply new plugins
 */
function essence_clean_plugins( $content ) {
    $current_path = '/wp-content/plugins';
    $new_path = '/plugins';
    $content = str_replace( $current_path, $new_path, $content );
    return $content;
}

/**
 * Only use clean URLs if the theme isn't a child or an MU (Network) install
 */
if (!is_multisite() && !is_child_theme()) {
  add_action( 'generate_rewrite_rules', 'essence_add_rewrites' );
  if ( !is_admin() ) {
    add_filter( 'plugins_url', 'essence_clean_plugins' );
    add_filter( 'bloginfo', 'essence_clean_assets' );
    add_filter( 'stylesheet_directory_uri', 'essence_clean_assets' );
    add_filter( 'template_directory_uri', 'essence_clean_assets' );
  }
}

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