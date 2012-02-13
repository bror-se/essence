<?php
/**
 * Redirect /?s to /search/
 * http://txfx.net/wordpress-plugins/nice-search/
 */

function essence_search_redirect() {
  if (is_search() && strpos($_SERVER['REQUEST_URI'], '/wp-admin/') === false && strpos($_SERVER['REQUEST_URI'], '/search/') === false) {
    wp_redirect(home_url('/search/' . str_replace(array(
      ' ',
      '%20'
    ), array(
      '+',
      '+'
    ), urlencode(get_query_var('s')))), 301);
    exit();
  }
}
add_action('template_redirect', 'essence_search_redirect');


function essence_search_query($escaped = true) {
  $query = apply_filters('essence_search_query', get_query_var('s'));
  if ($escaped) {
    $query = esc_attr($query);
  }
  return urldecode($query);
}
add_filter('get_search_query', 'essence_search_query');


/**
 * Fix for empty search query
 * http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 */
function essence_request_filter($query_vars) {
  if (isset($_GET['s']) && empty($_GET['s'])) {
    $query_vars['s'] = " ";
  }
  return $query_vars;
}
add_filter('request', 'essence_request_filter');


/**
 * Root relative URLs for everything
 * http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 */

function essence_root_relative_url($input) {
  $output = preg_replace_callback('!(https?://[^/|"]+)([^"]+)?!', create_function('$matches',
  // if full URL is site_url, return a slash for relative root
    'if (isset($matches[0]) && $matches[0] === site_url()) { return "/";' .
  // if domain is equal to site_url, then make URL relative
    '} elseif (isset($matches[0]) && strpos($matches[0], site_url()) !== false) { return $matches[2];' .
  // if domain is not equal to site_url, do not make external link relative
    '} else { return $matches[0]; };'), $input);
  return $output;
}


/**
 * Terrible workaround to remove the duplicate subfolder in the src of JS/CSS tags
 * Example: /subfolder/subfolder/css/style.css
 */

function essence_fix_duplicate_subfolder_urls($input) {
  $output = essence_root_relative_url($input);
  preg_match_all('!([^/]+)/([^/]+)!', $output, $matches);
  if (isset($matches[1]) && isset($matches[2])) {
    if ($matches[1][0] === $matches[2][0]) {
      $output = substr($output, strlen($matches[1][0]) + 1);
    }
  }
  return $output;
}

/**
 * Apply relative URLs
 */

if (!is_admin() && !in_array($GLOBALS['pagenow'], array(
  'wp-login.php',
  'wp-register.php'
))) {
  add_filter('bloginfo_url', 'essence_root_relative_url');
  add_filter('theme_root_uri', 'essence_root_relative_url');
  add_filter('stylesheet_directory_uri', 'essence_root_relative_url');
  add_filter('template_directory_uri', 'essence_root_relative_url');
  add_filter('script_loader_src', 'essence_fix_duplicate_subfolder_urls');
  add_filter('style_loader_src', 'essence_fix_duplicate_subfolder_urls');
  add_filter('plugins_url', 'essence_root_relative_url');
  add_filter('the_permalink', 'essence_root_relative_url');
  add_filter('wp_list_pages', 'essence_root_relative_url');
  add_filter('wp_list_categories', 'essence_root_relative_url');
  add_filter('wp_nav_menu', 'essence_root_relative_url');
  add_filter('the_content_more_link', 'essence_root_relative_url');
  add_filter('the_tags', 'essence_root_relative_url');
  add_filter('get_pagenum_link', 'essence_root_relative_url');
  add_filter('get_comment_link', 'essence_root_relative_url');
  add_filter('month_link', 'essence_root_relative_url');
  add_filter('day_link', 'essence_root_relative_url');
  add_filter('year_link', 'essence_root_relative_url');
  add_filter('tag_link', 'essence_root_relative_url');
  add_filter('the_author_posts_link', 'essence_root_relative_url');
}

/**
 * Remove root relative URLs on any attachments in the feed
 */

function essence_root_relative_attachment_urls() {
  if (!is_feed()) {
    add_filter('wp_get_attachment_url', 'essence_root_relative_url');
    add_filter('wp_get_attachment_link', 'essence_root_relative_url');
  }
}
add_action('pre_get_posts', 'essence_root_relative_attachment_urls');

?>
