<?php
/**
 * Essence htaccess
 *
 * @package Wordpress
 * @subpackage Essence
 */

if (stristr($_SERVER['SERVER_SOFTWARE'], 'apache') !== false) {
  /**
   * Add notice in admin if htaccess isn't writable
   */
  function essence_htaccess_writable() {
    if (!is_writable(get_home_path() . '.htaccess')) {
      if (current_user_can('administrator')) {
        add_action('admin_notices', create_function('', "echo '<div class=\"error\"><p>" . sprintf(__('Please make sure your <a href="%s">.htaccess</a> file is writable ', 'essence'), admin_url('options-permalink.php')) . "</p></div>';"));
      }
    }
    ;
  }
  add_action('admin_init', 'essence_htaccess_writable');

  /**
   * Flush rewrite rules
   */
  function essence_flush_rewrites() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
  }

  /**
   * Add rewrites
   */
  function essence_add_rewrites($content) {
    $theme_name = next(explode('/themes/', get_stylesheet_directory()));
    global $wp_rewrite;
    $essence_new_non_wp_rules = array(
      'css/(.*)' => 'wp-content/themes/' . $theme_name . '/css/$1',
      'js/(.*)' => 'wp-content/themes/' . $theme_name . '/js/$1',
      'img/(.*)' => 'wp-content/themes/' . $theme_name . '/img/$1',
      'plugins/(.*)' => 'wp-content/plugins/$1'
    );
    $wp_rewrite->non_wp_rules += $essence_new_non_wp_rules;
  }
  add_action('admin_init', 'essence_flush_rewrites');

  /**
   * Apply new path to assets
   */
  function essence_clean_assets($content) {
    $theme_name   = next(explode('/themes/', $content));
    $current_path = '/wp-content/themes/' . $theme_name;
    $new_path     = '';
    $content      = str_replace($current_path, $new_path, $content);
    return $content;
  }

  /**
   * Apply new path to plugins
   */
  function essence_clean_plugins($content) {
    $current_path = '/wp-content/plugins';
    $new_path     = '/plugins';
    $content      = str_replace($current_path, $new_path, $content);
    return $content;
  }

  /**
   * Only use clean URLs if the theme isn't a child or an MU (Network) install
   */
  if (!is_multisite() && !is_child_theme()) {
    add_action('generate_rewrite_rules', 'essence_add_rewrites');
    if (!is_admin()) {
      add_filter('plugins_url', 'essence_clean_plugins');
      add_filter('bloginfo', 'essence_clean_assets');
      add_filter('stylesheet_directory_uri', 'essence_clean_assets');
      add_filter('template_directory_uri', 'essence_clean_assets');
      add_filter('script_loader_src', 'essence_clean_plugins');
      add_filter('style_loader_src', 'essence_clean_plugins');
    }
  }

  /**
   * Add custom htaccess to Wordpress
   */
  function essence_add_htaccess($rules) {
    global $wp_filesystem;

    if (!defined('FS_METHOD'))
      define('FS_METHOD', 'direct');
    if (is_null($wp_filesystem))
      WP_Filesystem(array(), ABSPATH);

    $filename = __DIR__ . '/essence-htaccess';

    return $rules . $wp_filesystem->get_contents($filename);
  }
  add_filter('mod_rewrite_rules', 'essence_add_htaccess');

}

?>
