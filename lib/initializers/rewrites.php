<?php
// Check to see if server is Apache
if (stristr($_SERVER['SERVER_SOFTWARE'], 'apache') !== false) {

  /**
   * Check if htaccess is writable
   */

  function essence_htaccess_writable() {
    if (!is_writable(get_home_path() . '.htaccess')) {
      if (current_user_can('administrator')) {
        add_action('admin_notices', create_function('', "echo '<div class=\"error\"><p>" . sprintf(__('Please make sure your <a href="%s">.htaccess</a> file is writable ', 'essence'), admin_url('options-permalink.php')) . "</p></div>';"));
      }
    };
  }
  add_action('admin_init', 'essence_htaccess_writable');


  /**
   * Define rewrites
   * Rewrites DO NOT happen for child themes
   */

  function essence_add_rewrites($content) {
    global $wp_rewrite;
    $theme_name = next(explode('/themes/', get_stylesheet_directory()));
    $new_non_wp_rules = array(
      'css/(.*)'      => 'wp-content/themes/'. $theme_name . '/css/$1',
      'js/(.*)'       => 'wp-content/themes/'. $theme_name . '/js/$1',
      'img/(.*)'      => 'wp-content/themes/'. $theme_name . '/img/$1',
      'plugins/(.*)'  => 'wp-content/plugins/$1'
    );
    $wp_rewrite->non_wp_rules = $new_non_wp_rules;
    return $content;
  }


  /**
   * Apply new path to assets
   */

  function essence_clean_assets($content) {
    $theme_name = next(explode('/themes/', $content));
    $current_path = '/wp-content/themes/' . $theme_name;
    $new_path = '';
    $content = str_replace($current_path, $new_path, $content);
    return $content;
  }


  /**
   * Apply new path to plugins
   */

  function essence_clean_plugins($content) {
      $current_path = '/wp-content/plugins';
      $new_path = '/plugins';
      $content = str_replace($current_path, $new_path, $content);
      return $content;
  }


  /**
   * Only use clean URLs if the theme isn't a child or an MU (Network) install
   */

  if (!is_multisite() && !is_child_theme()) {
    add_action('generate_rewrite_rules', 'essence_add_rewrites');
    add_action('generate_rewrite_rules', 'essence_add_htaccess');
    add_action('activate_plugin', 'essence_add_htaccess');
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

  function essence_add_htaccess($content) {
    global $wp_rewrite;

    if (!function_exists('get_home_path')) {
      return;
    }

    $home_path = get_home_path();
    $htaccess_file = $home_path . '.htaccess';

    if ((!file_exists($htaccess_file) && is_writable($home_path) && $wp_rewrite->using_mod_rewrite_permalinks()) || is_writable($htaccess_file)) {
      if (got_mod_rewrite()) {
        $rules = extract_from_markers($htaccess_file, 'HTML5 Boilerplate');
          if ($rules === array()) {
            $filename = __DIR__ . '/htaccess';
          return insert_with_markers($htaccess_file, 'HTML5 Boilerplate', extract_from_markers($filename, 'HTML5 Boilerplate'));
          }
      }
    }

    return $content;
  }

}

?>
